package cost;

import common.ExtensionFileFilter;
import common.Functions;
import common.HashObject;
import common.IteratorHashObject;
import common.LoadSaveFile;
import common.PhpScriptRunner;
import common.Saveable;
import common.TreeFileLoader;
import common.VectorObject;
import java.awt.AWTEvent;
import java.awt.Color;
import java.awt.Desktop;
import java.awt.Dimension;
import java.awt.HeadlessException;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowEvent;
import java.io.File;
import java.io.IOException;
import java.io.OutputStream;
import java.io.UnsupportedEncodingException;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.URLDecoder;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;
import java.util.concurrent.Executors;
import java.util.concurrent.TimeUnit;
import javax.swing.ButtonGroup;
import javax.swing.ImageIcon;
import javax.swing.JCheckBoxMenuItem;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JMenu;
import javax.swing.JMenuBar;
import javax.swing.JMenuItem;
import javax.swing.JOptionPane;
import javax.swing.JRadioButtonMenuItem;
import javax.swing.JTabbedPane;
import javax.swing.UIManager;
import javax.swing.UIManager.LookAndFeelInfo;
import javax.swing.UnsupportedLookAndFeelException;

public class MainFrame extends JFrame implements ActionListener {
	private static JMenuItem[] menu;

	public static Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
	public static String rootPath;
	public static String ini = System.getProperty("user.home") + "/cost.ini";
	static protected HashObject data;
	static protected IteratorHashObject costs;
	static protected MainFrame ths;
	static protected CostWizardDialog cwf;

	public MainFrame() {
		super("������������ ������� 1.6.7b");
		setIconImage(new ImageIcon(ClassLoader.getSystemResource("cost/app.png")).getImage());

		// ������ �� ������������� �����!
		Providers prov = new Providers();
		Men men = new Men();
		Holds holds = new Holds();
		Contents contents = new Contents();

		// �� tabbed panel ������ �� ����� ����� �������� ��� ������ ���
		// �� �������� �� 4� �������� ��� tabbed panel.
		// �������� ��� Bills �� ������ ����������.
		// ��� ���� ������������-�������������� �������� ���� �������-������� ������.
		JTabbedPane mainTab = new JTabbedPane();
		mainTab.addTab("�������� �������", new CostData(contents));
		mainTab.addTab("���������", new Bills());
		mainTab.addTab("����� �����������", contents);
		mainTab.addTab("��������", new Works());
		mainTab.addTab("���������� ��������", new StaticData());
		mainTab.addTab("�����������", prov);
		mainTab.addTab("������� ���������", holds);
		mainTab.addTab("��������� �������", men);

		getContentPane().add(mainTab);
		Color c = Color.decode("#b0d0b0");
		mainTab.setBackgroundAt(0, c);
		mainTab.setBackgroundAt(1, c);
		mainTab.setBackgroundAt(2, c);
		mainTab.setBackgroundAt(3, c);
		c = Color.decode("#e0e0b0");
		mainTab.setBackgroundAt(4, c);
		mainTab.setBackgroundAt(5, c);
		mainTab.setBackgroundAt(6, c);
		mainTab.setBackgroundAt(7, c);

		updatePanels();

		setJMenuBar(createMenus(new JMenuBar()));
		updateMenus();
		addOptionsMenu();

		setSize(750, 450);
		setLocation((screenSize.width - getWidth()) / 2, (screenSize.height - getHeight()) / 2);
		setVisible(true);
		enableEvents(AWTEvent.WINDOW_EVENT_MASK);
	}

	
	private JMenuBar createMenus(JMenuBar jtb) {
		final String[] mnu = {
			"������", null, null,
				"��� ������", "������", "new",
				"������� �������...", "������", "open",
				"���������� �������...", "������", "save",
				"�������� �������", "������", "close",
				null, "������", null,
				"�������� ���������...", "������", "import",
				null, "������", null,
				"������", "������", "exit",
			"�������", null, null,
				"������", "�������", null,
				"��", "�������", null,
					"������", "��", null,
					"�����������", "��", null,
				"������������", "�������", null,
					"���������� ���������", "������������", null,
					"�����������", "������������", null,
						"���������", "�����������", null,
						null, "�����������", null,
						"��������", "�����������", null,
						"���������� ������", "�����������", null,
						"����������", "�����������", null,
					"������������ �������", "������������", null,
					"������ ������������ �������", "������������", null,
				"�������", "�������", null,
					"������� ���������", "�������", null,
					"�������� ����� ����������", "�������", null,
					"�������� ��� �����������", "�������", null,
			"���������", null, null,
				"������ ����������", "���������", "wizard",
				null, "���������", null,
				"������� ", "���������", "skins",
			"�������", null, null,
			"�������", null, null,
				"����������", "�������", "help",
				"����...", "�������", "about"
		};
		menu = new JMenuItem[mnu.length / 3];
			
		for(int z = 0, c = 0; z < mnu.length; z += 3)
			if (mnu[z] == null) ((JMenu) getMenuFromName(mnu[z + 1])).addSeparator();
			else {
			if (mnu[z + 1] == null || mnu[z].endsWith(" ") || z + 4 < mnu.length && mnu[z + 4] == mnu[z])
				menu[c] = new JMenu(mnu[z]);
			else {
				menu[c] = new JMenuItem(mnu[z]);
				menu[c].addActionListener(this);
			}
			if (mnu[z + 2] != null) {
				/*if (mnu[z + 2] == "") menu[c].setIcon(new MenuBlankIcon());
				else*/ menu[c].setIcon(new ImageIcon(ClassLoader.getSystemResource("cost/" + mnu[z + 2] + ".png")));
			}
			if (mnu[z + 1] == null) jtb.add(menu[c++]);
			else ((JMenu) getMenuFromName(mnu[z + 1])).add(menu[c++]);
			}
		return jtb;
	}

	static private JMenuItem getMenuFromName(String s) {
		for(int z = 0; menu[z] != null; z++)
			if (s.equals(menu[z].getText())) return menu[z];
		return null;
	}

	public void newCost() {
		try {
			for(int z = 0;; z++) {
				String s = new File("��� ������ - " + z + ".cost").getCanonicalPath();
				if (!costs.containsKey(s)) {
					Cost c = new Cost();
					c.putAll((Map) data.get("�������������������������"));
					costs.add(s, c);
					updateMenus();
					updatePanels();
					return;
				}
			}
		} catch (IOException e) {}
	}

	public void saveCost() {
		try {
			JFileChooser fc = new JFileChooser(costs.getPos());
			fc.setSelectedFile(new File(costs.getPos()));
			fc.setFileFilter(new ExtensionFileFilter("cost", "������ �������"));
			if(fc.showSaveDialog(this) != JFileChooser.APPROVE_OPTION) return;
			File f = fc.getSelectedFile();
			String s = f.getCanonicalPath();
			if (!s.endsWith(".cost")) s += ".cost";
			if (!s.equals(costs.getPos())) {
				if (costs.containsKey(s)) {
					JOptionPane.showMessageDialog(this, "�� ����� ���� ������� �� ���� ������� ������.\n"
							+ "�������� ����� ���� �����.", "���������� �������", JOptionPane.ERROR_MESSAGE);
					return;
				} else if (f.exists()) {
					if (JOptionPane.NO_OPTION == JOptionPane.showConfirmDialog(this,
							"�� ������ ���� ������� ��� �� �����.\n������ �� ��������;",
							"���������� �������", JOptionPane.YES_NO_OPTION, JOptionPane.WARNING_MESSAGE))
						return;
				}
			}
			LoadSaveFile.save(s, (Saveable) costs.get());
			if (!s.equals(costs.getPos())) {
				costs.add(s, costs.remove());
				updateMenus();
			}
		} catch(Exception e) {
			Functions.showExceptionMessage(this, e, "���������� �������", "�������� ���� ��� ���������� ��� �������");
		}
	}

	private void openCost() {
		try {
			JFileChooser fc = new JFileChooser(costs.getPos());
			fc.setFileFilter(new ExtensionFileFilter("cost", "������ �������"));
			int returnVal = fc.showOpenDialog(this);
			if(returnVal != JFileChooser.APPROVE_OPTION) return;
			String s = fc.getSelectedFile().getCanonicalPath();
			if (!s.endsWith(".cost")) s += ".cost";
			openCost(s);
		} catch (HeadlessException | IOException ex) {}
	}

	static private void openCost(String file) {
		try {
			if (costs.containsKey(file)) {
				JOptionPane.showMessageDialog(ths, "�� ����� ���� ������� �� ������� ������.\n"
						+ "��� �� �������� ���� �� ������ �� ������ �� �������� ��� ������� �������.",
						"������� �������", JOptionPane.ERROR_MESSAGE);
				return;
			}
			costs.add(file, TreeFileLoader.loadFile(file));
			if (ths != null) {
				ths.updateMenus();
				ths.updatePanels();
			}
		} catch (Exception e) {
			Functions.showExceptionMessage(ths, e, "������� �������",
					"�������� ���� �� ������� ��� �������<br><b>" + file + "</b>");
		}
	}

	private void importCost() {
		try {
			JFileChooser fc = new JFileChooser(ini);
			fc.setMultiSelectionEnabled(true);
			fc.setFileFilter(new ExtensionFileFilter("ini:cost", "������ ������� ��� ���������"));
			int returnVal = fc.showOpenDialog(this);
			if(returnVal != JFileChooser.APPROVE_OPTION) return;
			File[] files = fc.getSelectedFiles();
			final String choices[] = new String[] { "�����������, ���������, ���������", "�����������, ���������",
				"���������� ��������", "�����������", "���������", "���������" };
			final char fchoices[] = new char[] { 7, 5, 8, 4, 2, 1 };
			Object a = JOptionPane.showInputDialog(this,
					"�������� �� �� ������� ��� �� ����������� ������ ������� ��� ���������\n"
					+ "��� �������� ��� �������� ��� ������������", "�������� ��������� ��� ������ ������� ��� ���������",
					JOptionPane.QUESTION_MESSAGE, null, choices, choices[0]);
			if (a == null) return;
			char flags = fchoices[Arrays.asList(choices).indexOf(a)];
			for (File f1 : files) {
				importCost(f1.getCanonicalPath(), flags);
				flags &= 7;
			}
		} catch (HeadlessException | IOException ex) {}
		repaint();
	}

	// flags: 1: Man, 2: Hold, 4: Provider, 8: StaticData
	static private void importCost(String file, char flags) {
		ArrayList<Hold> holds = (ArrayList<Hold>) data.get("���������");
		ArrayList<Man> men = (ArrayList<Man>) data.get("���������");
		ArrayList<Provider> providers = (ArrayList<Provider>) data.get("�����������");
		HashObject staticdata = (HashObject) data.get("�������������������������");
		try {
			Object o = TreeFileLoader.loadFile(file);
			if (o instanceof Cost) {
				Cost c = (Cost) o;
				if ((flags & 1) != 0)
					for (Object man : c.values())
						if (man instanceof Man && !men.contains((Man) man))
							men.add((Man) man);
				ArrayList<Bill> b = (ArrayList<Bill>) c.get("���������");
				for (Bill b1 : b) {
					if ((flags & 2) != 0) {
						Hold h = (Hold) b1.get("�������������������������");
						if (h != null && !holds.contains(h)) holds.add(h);
					}
					if ((flags & 4) != 0) {
						Provider p = (Provider) b1.get("�����������");
						if (p != null && !providers.contains(p)) providers.add(p);
					}
				}
				if ((flags & 8) != 0)
					for (String hash : StaticData.hash)
						if (c.containsKey(hash))
							staticdata.put(hash, c.get(hash));
			} else if (o instanceof HashObject) {
				if ((flags & 1) != 0)
					for (Man m : (VectorObject<Man>) ((HashObject) o).get("���������"))
						if (!men.contains(m)) men.add(m);
				if ((flags & 2) != 0)
					for (Hold h : (VectorObject<Hold>) ((HashObject) o).get("���������"))
						if (!holds.contains(h)) holds.add(h);
				if ((flags & 4) != 0)
					for (Provider p : (VectorObject<Provider>) ((HashObject) o).get("�����������"))
						if (!providers.contains(p)) providers.add(p);
				if ((flags & 8) != 0) {
						staticdata.clear();
						staticdata.putAll((HashObject) ((HashObject) o).get("�������������������������"));
				}
			}
		} catch (Exception e) {
			Functions.showExceptionMessage(ths, e, "������� �������",
					"�������� ���� �� ������� ��� ������� ������� � ���������<br><b>" + file + "</b>");
		}
	}

	private void closeCost() {
		if (JOptionPane.YES_OPTION == JOptionPane.showConfirmDialog(this,
				"<html>�� ������ ��� �������� ������;", "�������� �������",
				JOptionPane.YES_NO_OPTION, JOptionPane.WARNING_MESSAGE)) {
			costs.remove();
			updatePanels();
			updateMenus();
		}
	}

	private void updatePanels() {
		JTabbedPane j = (JTabbedPane) getContentPane().getComponent(0);
		for (int z = 0; z < 4; z++)
			j.setEnabledAt(z, costs.getPos() != null);
		if (costs.getPos() == null && j.getSelectedIndex() < 4) j.setSelectedIndex(4);
		repaint();
	}

	private void updateMenus() {
		getMenuFromName("���������� �������...").setEnabled(costs.getPos() != null);
		getMenuFromName("�������� �������").setEnabled(costs.getPos() != null);
		getMenuFromName("�������").setEnabled(costs.getPos() != null);
		JMenu window = (JMenu) getMenuFromName("�������");
		window.setEnabled(costs.getPos() != null);

		if (costs.getPos() != null) {
			window.removeAll();
			ButtonGroup btg = new ButtonGroup();
			Iterator en = costs.keySet().iterator();
			while (en.hasNext()) {
				String m = en.next().toString();
				JRadioButtonMenuItem jmi = new JRadioButtonMenuItem(new File(m).getName(), m.equals(costs.getPos()));
				jmi.addActionListener(this);
				jmi.setActionCommand(m);
				btg.add(jmi);
				window.add(jmi);
			}
		}
	}

	@Override
	protected void processWindowEvent(WindowEvent e) {
		if (e.getID() == WindowEvent.WINDOW_CLOSING) {
			try {
				LoadSaveFile.save(ini, data);
			} catch(Exception ex) {
				if (JOptionPane.NO_OPTION == JOptionPane.showConfirmDialog(this,
						"<html>�������� ���� ��� ���������� ��� <b>cost.ini</b>.<br>�� ������ �o ���������;",
						"�����������", JOptionPane.YES_NO_OPTION, JOptionPane.WARNING_MESSAGE))
					return;
			}
			System.exit(0);
		}
		super.processWindowEvent(e);
	}

	public final void addOptionsMenu() {
		JMenu options = (JMenu) getMenuFromName("���������");
		HashObject h = (HashObject) data.get("���������");
		JCheckBoxMenuItem cbmi = new JCheckBoxMenuItem("��� ���������",
				new ImageIcon(ClassLoader.getSystemResource("cost/only_one.png")),
				Boolean.TRUE.equals(h.get("�������")));
		cbmi.addActionListener(this);
		options.add(cbmi);
		
		cbmi = new JCheckBoxMenuItem("����������� ������� ����������",
				new ImageIcon(ClassLoader.getSystemResource("cost/chain.png")),
				Boolean.TRUE.equals(h.get("��������������������")));
		cbmi.addActionListener(this);
		options.add(cbmi);

		JMenuItem skins = getMenuFromName("������� ");
		LookAndFeelInfo[] laf = UIManager.getInstalledLookAndFeels();
		String s = (String) h.get("�������");
		if (s == null) s = UIManager.getSystemLookAndFeelClassName();
		ButtonGroup btg = new ButtonGroup();
		for (LookAndFeelInfo laf1 : laf) {
			String s1 = laf1.getClassName();
			JRadioButtonMenuItem jmi = new JRadioButtonMenuItem(laf1.getName(), s1.equals(s));
			jmi.setActionCommand(s1);
			jmi.addActionListener(this);
			btg.add(jmi);
			skins.add(jmi);
		}
	}

	static public void setSkin() {
		try {
			UIManager.setLookAndFeel(((HashObject) data.get("���������")).get("�������").toString());
		} catch(NullPointerException | ClassNotFoundException | IllegalAccessException
				| InstantiationException | UnsupportedLookAndFeelException e) {
			try {
				UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
			} catch(ClassNotFoundException | InstantiationException | IllegalAccessException | UnsupportedLookAndFeelException ex) {}
		}
	}

	public static void main(String[] args) {
		// check for other running instance and setup listening server
		if (!OnlyOneInstance.check()) {
			for (String arg : args)
				OnlyOneInstance.send(arg.getBytes());
			System.exit(0);
		}

		try {
			// init php engine
			PhpScriptRunner.init(null);
		} catch (Exception e) {
			Functions.showExceptionMessage(null, e, "�������� ��� PHP cli",
				"�������� ���� ��� ������������ ��� <b>PHP cli</b>.<br>�� ��������� �� ����������.");
			System.exit(0);
		}

		try {
			// get application path
			rootPath = URLDecoder.decode(ClassLoader.getSystemResource("cost/MainFrame.class").getPath().
				replaceAll("(Cost\\.jar!/)?cost/MainFrame\\.class$|^(file\\:)?/", ""), "UTF-8");
		} catch (UnsupportedEncodingException ex) {
			rootPath = "";
		}

		// load ini file and create data structure
		Object o = null;
		try {
			o = TreeFileLoader.loadFile(ini);
		} catch(Exception e) {
			Functions.showExceptionMessage(null, e, "��������",
				"�������� ���� �� ������� ��� <b>cost.ini</b><br>"
				+ "�� ������� ��� ����� ���� �� ��������� ��� ������� ����� ���������.<br>"
				+ "�� ������� �� default ������ ���.");
			try {
				o = TreeFileLoader.loadResource("cost.ini");
			} catch(Exception e2) {
				Functions.showExceptionMessage(null, e2, "��������",
					"�������� ���� �� ������� ��� default <b>cost.ini</b>.");
			}
		}
		data = o instanceof HashObject ? (HashObject) o : new HashObject();
		if (!(data.get("���������") instanceof VectorObject)) data.put("���������", new VectorObject<>());
		if (!(data.get("�����������") instanceof VectorObject)) data.put("�����������", new VectorObject<>());
		if (!(data.get("���������") instanceof VectorObject)) data.put("���������", new VectorObject<>());
		if (!(data.get("�������������������������") instanceof HashObject)) data.put("�������������������������", new HashObject());
		if (!(data.get("���������") instanceof HashObject)) data.put("���������", new HashObject());
		if (!(data.get("���������������") instanceof IteratorHashObject)) data.put("���������������", new IteratorHashObject());
		costs = (IteratorHashObject) data.get("���������������");			// shortcut

		setSkin();
		try {
			for (String arg : args)
				openCost(new File(arg).getCanonicalPath());
		} catch (IOException ex) {}

		ths = new MainFrame();
		
		// Autosave ini file every 5 minutes.
		Executors.newSingleThreadScheduledExecutor().scheduleAtFixedRate(() -> {
				try {
					LoadSaveFile.save(ini, data);
				} catch(Exception ex) {}
			}, 5, 5, TimeUnit.MINUTES);
	}

	// ----- ActionListener ----- //

	@Override
	public void actionPerformed(ActionEvent e) {
		JMenuItem j = (JMenuItem) e.getSource();
		String ac = j.getText();
		int order = -1;

		// if we must output only one copy
		Map<String, String> env = new HashMap<>();
		Map<String, Object> options = (HashObject) data.get("���������");
		if (Boolean.TRUE.equals(options.get("�������"))) env.put("one", "true");

		if (((JMenu) getMenuFromName("������� ")).isMenuComponent(j)) {
			options.put("�������", e.getActionCommand());
			setSkin(); dispose(); ths = new MainFrame();
		} else if (((JMenu) getMenuFromName("�������")).isMenuComponent(j)) {
			costs.setPos(e.getActionCommand());
			updatePanels();
		}
		else if (ac.equals("��� ������")) newCost();
		else if (ac.equals("������� �������...")) openCost();
		else if (ac.equals("���������� �������...")) saveCost();
		else if (ac.equals("�������� ���������...")) importCost();
		else if (ac.equals("�������� �������")) closeCost();
		else if (ac.equals("������")) dispatchEvent(new WindowEvent(this, WindowEvent.WINDOW_CLOSING));
		else if (ac.equals("������")) ExportReport.exportReport("������.php", env);
		else if (ac.equals("������")) ExportReport.exportReport("�� ��� ��� ������.php");
		else if (ac.equals("�����������")) ExportReport.exportReport("�� ��� ��� ����������.php");
		else if (ac.equals("���������� ���������")) order = 0;
		else if (ac.equals("���������")) order = 1;
		else if (ac.equals("����������")) order = 2;
		else if (ac.equals("������������ �������")) order = 3;
		else if (ac.equals("������ ������������ �������")) order = 4;
		else if (ac.equals("���������� ������")) ExportReport.exportReport("���������� ������ �����������.php");
		else if (ac.equals("��������")) ExportReport.exportReport("�������� �����������.php");
		else if (ac.equals("������� ���������")) ExportReport.exportReport("��������� ���� ������.php");
		else if (ac.equals("�������� ����� ����������")) ExportReport.exportReport("�������� ����� ����������.php");
		else if (ac.equals("�������� ��� �����������")) ExportReport.exportReport("�������� ��� �����������.php");
		else if (ac.equals("��� ���������")) options.put("�������", Boolean.FALSE.equals(options.get("�������")));
		else if (ac.equals("������ ����������")) {
			if (cwf == null) cwf = new CostWizardDialog(this);
			cwf.setVisible(true);
		}
		else if (ac.equals("����������� ������� ����������")) {
			boolean a = Boolean.TRUE.equals(options.get("��������������������"));
			options.put("��������������������", !a);
			Cost c = (Cost) costs.get();
			if (a && c != null) {
				ArrayList<Bill> b = (ArrayList<Bill>) c.get("���������");
				for (Bill b1 : b) b1.recalculate();
				repaint();
			}
		}
		else if (ac.equals("����������")) {
			try {	// open help
				Desktop.getDesktop().open(new File(rootPath + "help/index.html"));
			} catch(IllegalArgumentException | IOException ex) {
				Functions.showExceptionMessage(this, ex, "�������� ���� �������� ��� browser", null);
			}
		}
		else if (ac.equals("����...")) JOptionPane.showMessageDialog(this,
				"<html><center><b><font size=4>������������ �������</font><br>" +
				"<font size=3>������ 1.6.7b</font></b></center><br>" +
				"���������������: <b>������ ������ (��� 2002)</b><br>" +
				"����� ������: <b>BSD</b><br>" +
				"����������: <b>11 ���� 17</b><br>" +
				"������: <b>http://sourceforge.net/projects/ha-expenditure/</b><br><br>" +
				"<center>�� ��������� ����� 13 ������!</center>",
				getTitle(), JOptionPane.PLAIN_MESSAGE);
		
		// �� ����� ������� ������� extra dialog ��� ������ � ������� ���������
		if (order != -1) {
			final String[] file = { "��� ����������� ���������", "��� ���������� �����������",
				"��� ����������� �����������", "������������ �������", "������ ������������ �������" };
			final String[] a = { "������� ���������", "������" };
			int b = JOptionPane.showOptionDialog(this, "�������� ��� �� �� ���� � �������.",
					"�������", JOptionPane.OK_CANCEL_OPTION, JOptionPane.QUESTION_MESSAGE, null, a, a[0]);
			if (b == JOptionPane.CLOSED_OPTION) return;
			else if (b == 1) env.put("draft", "true");
			ExportReport.exportReport(file[order] + ".php", env);
		}
	}


	private static class OnlyOneInstance implements Runnable {
		private static ServerSocket ss;
		public static boolean check() {
			try {
				ss = new ServerSocket(666);
				new Thread(new OnlyOneInstance()).start();
				return true;
			} catch(IOException e) { return false; }
		}

		public static void send(byte[] a) {
			try {
				try (OutputStream s = new Socket("127.0.0.1", 666).getOutputStream()) { s.write(a); }
			} catch(IOException e) {}
		}

		@Override
		public void run() {
			try {
				for(;;) {
					Socket s = ss.accept();
					openCost(new File(LoadSaveFile.loadFile(s.getInputStream())).getCanonicalPath());
				}
			} catch(Exception e) {}
		}
	}

	/*class MenuBlankIcon implements Icon {
		public int getIconHeight() { return 16; }
		public int getIconWidth() { return 16; }
		public void paintIcon(Component c, Graphics g, int x, int y) {}
	}*/
}