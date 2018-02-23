package cost;

import java.io.*;
import java.util.*;
import java.net.*;
import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.UIManager.*;

import common.*;


public class MainFrame extends JFrame implements ActionListener {
	static private final String[] mnu = {
		"file", null, null, "������",
			"new", "file", "new", "��� ������",
			"open", "file", "open", "������� �������...",
			"save", "file", "save", "���������� �������...",
			"close", "file", "close", "�������� �������",
			null, "file", null, null,
			"exit", "file", "exit", "������",
		"export", null, null, "�������",
			"cost", "export", null, "������",
			"fe", "export", null, "��",
				"taxis", "fe", null, "������",
				"provider", "fe", null, "�����������",
			"mail", "export", null, "������������",
				"order_order", "mail", null, "���������� ���������",
				"contract", "mail", null, "����������",
					"order_order_contractor", "contract", null, "������� ����������",
					"order_order_work_officer", "contract", null, "������� ����� �����",
					"order_order_obscure_work", "contract", null, "���������� ��������� ������ ��������",
					"order_order_temporary_finally_taking", "contract", null, "���������� ��������� ���������� ��� ��������� ���������",
					"order_order_quality_quantity", "contract", null, "���������� ��������� ��������� ��� ��������� ���������",
					"order_order_buy_service", "contract", null, "���������� ��������� ������ ��� ��������",
				"contest", "mail", null, "�����������",
					"order_order_contest", "contest", null, "���������� ��������� �����������",
					"order_order_declaration", "contest", null, "��������� �����������",
					"contest_record", "contest", null, "�������� �����������...",
					"contest_proposal", "contest", null, "���������� ������...",
					"order_order_adjudication", "contest", null, "���������� ��� �����������...",
				"order_route_slip", "mail", null, "������������ �������",
				"order_prereport", "mail", null, "������ ������������ �������",
			"other", "export", null, "�������",
				"hold", "other", null, "������� ���������",
				"bills", "other", null, "����� ����������",
				"ticket", "other", null, "�������� ��� �����������",
		"options", null, null, "���������",
			"skins", "options", "skins", "������� ",
			"openwith", "options", "openwith", "������� ��...",
			"fexport", "options", "export", "������� ",
		"costs", null, null, "�������",
		"help", null, null, "�������",
			"help_open", "help", "help", "�������",
			"about", "help", "about", "����..."
	};
	private static JMenuItem[] menu = new JMenuItem[mnu.length / 4];

	public static Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
	public static String rootPath;
	static protected HashObject data;
	static protected IteratorHashObject costs;
	static protected MainFrame ths;

	public MainFrame() {
		super("������������ ������� 1.4.8");
		setIconImage(new ImageIcon(ClassLoader.getSystemResource("cost/app.png")).getImage());

		Providers prov = new Providers();
		Men men = new Men();
		Holds holds = new Holds();
		Contents contents = new Contents();

		JTabbedPane mainTab = new JTabbedPane();
		mainTab.addTab("�������� �������", new CostData(contents));
		mainTab.addTab("���������", new Bills());
		mainTab.addTab("����� �����������", contents);
		mainTab.addTab("��������", new Works());
		mainTab.addTab("���������� ��������", new StaticData());
		mainTab.addTab("�����������", prov);
		mainTab.addTab("���������", holds);
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

		setSize(700, 450);
		setLocation((screenSize.width - getWidth()) / 2, (screenSize.height - getHeight()) / 2);
		setVisible(true);
		enableEvents(AWTEvent.WINDOW_EVENT_MASK);
	}

	private JMenuBar createMenus(JMenuBar jtb) {
		for(int z = 0, c = 0; z < mnu.length; z += 4)
			if (mnu[z] == null) ((JMenu) getMenuFromName(mnu[z + 1])).addSeparator();
			else {
			if (mnu[z + 1] == null || mnu[z + 3].endsWith(" ") || z + 5 < mnu.length && mnu[z + 5] == mnu[z])
				menu[c] = new JMenu(mnu[z + 3]);
			else {
				menu[c] = new JMenuItem(mnu[z + 3]);
				menu[c].addActionListener(this);
			}
			menu[c].setActionCommand(mnu[z]);
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
			if (s.equals(menu[z].getActionCommand())) return menu[z];
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
		} catch (Exception e) {}
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
					JOptionPane.showMessageDialog(this, "�� ����� ���� ������� �� ���� ������� ������.\n�������� ����� ���� �����.", "���������� �������", JOptionPane.ERROR_MESSAGE);
					return;
				} else if (f.exists()) {
					if (JOptionPane.NO_OPTION == JOptionPane.showConfirmDialog(this, "�� ������ ���� ������� ��� �� �����.\n������ �� ��������;", "���������� �������", JOptionPane.YES_NO_OPTION, JOptionPane.WARNING_MESSAGE))
						return;
				}
			}
			LoadSaveFile.save(s, (Saveable) costs.get());
			if (s != costs.getPos()) {
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
		} catch (Exception ex) {}
	}

	static private void openCost(String file) {
		try {
			if (costs.containsKey(file)) {
				JOptionPane.showMessageDialog(ths, "�� ����� ���� ������� �� ������� ������.\n��� �� �������� ���� �� ������ �� ������ �� �������� ��� ������� �������.", "������� �������", JOptionPane.ERROR_MESSAGE);
				return;
			}
			costs.add(file, TreeFileLoader.loadFile(file));
			if (ths != null) {
				ths.updateMenus();
				ths.updatePanels();
			}
		} catch (Exception e) {
			Functions.showExceptionMessage(ths, e, "������� �������", "�������� ���� �� ������� ��� �������<br><b>" + file + "</b>");
		}
	}

	private void closeCost() {
		if (JOptionPane.YES_OPTION == JOptionPane.showConfirmDialog(this, "<html>�� ������ ��� �������� ������;", "�������� �������", JOptionPane.YES_NO_OPTION, JOptionPane.WARNING_MESSAGE)) {
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
		getMenuFromName("save").setEnabled(costs.getPos() != null);
		getMenuFromName("close").setEnabled(costs.getPos() != null);
		getMenuFromName("export").setEnabled(costs.getPos() != null);
		JMenu window = (JMenu) getMenuFromName("costs");
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
				LoadSaveFile.save(System.getProperty("user.home") + "/cost.ini", data);
			} catch(Exception ex) {
				if (JOptionPane.NO_OPTION == JOptionPane.showConfirmDialog(this, "<html>�������� ���� ��� ���������� ��� <b>main.ini</b>.<br>�� ������ �o ���������;", "�����������", JOptionPane.YES_NO_OPTION, JOptionPane.WARNING_MESSAGE))
					return;
			}
			System.exit(0);
		}
		super.processWindowEvent(e);
	}

	public final void addOptionsMenu() {
		JMenu options = (JMenu) getMenuFromName("options");
		HashObject h = (HashObject) data.get("���������");
		JCheckBoxMenuItem cbmi = new JCheckBoxMenuItem("���� ��� ����", new ImageIcon(ClassLoader.getSystemResource("cost/only_one.png")), Boolean.TRUE.equals(h.get("�������")));
		cbmi.addActionListener(this);
		cbmi.setActionCommand("only_one");
		options.add(cbmi);

		JMenuItem skins = getMenuFromName("skins");
		LookAndFeelInfo[] laf = UIManager.getInstalledLookAndFeels();
		String s = (String) h.get("�������");
		if (s == null) s = UIManager.getSystemLookAndFeelClassName();
		ButtonGroup btg = new ButtonGroup();
		for (int z = 0; z < laf.length; z++) {
			String s1 = laf[z].getClassName();
			JRadioButtonMenuItem jmi = new JRadioButtonMenuItem(laf[z].getName(), s1.equals(s));
			jmi.setActionCommand(s1);
			jmi.addActionListener(this);
			btg.add(jmi);
			skins.add(jmi);
		}

		skins = getMenuFromName("fexport");
		s = (String) h.get("�������");
		if (s == null) s = ExportReport.x[0][1];
		btg = new ButtonGroup();
		for (int z = 0; z < ExportReport.x.length; z++) {
			JRadioButtonMenuItem jmi = new JRadioButtonMenuItem(ExportReport.x[z][0], ExportReport.x[z][1].equals(s));
			jmi.setActionCommand(ExportReport.x[z][1]);
			jmi.addActionListener(this);
			btg.add(jmi);
			skins.add(jmi);
		}
	}

	static public void setSkin() {
		try {
			UIManager.setLookAndFeel(((HashObject) data.get("���������")).get("�������").toString());
		} catch(Exception e) {
			try {
				UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
			} catch(Exception ex) {}
		}
	}

	public static void main(String[] args) {
		// check for other running instance and setup listening server
		if (!OnlyOneInstance.check()) {
			for (int z = 0; z < args.length; z++)
				OnlyOneInstance.send(args[z].getBytes());
			System.exit(0);
		}

		try {
			// init php engine
			PhpScriptRunner.init(null);
		} catch (Exception e) {
			Functions.showExceptionMessage(null, e, "�������� ��� PHP cli", "�������� ���� ��� ������������ ��� <b>PHP cli</b>.<br>�� ��������� �� ����������.");
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
			o = TreeFileLoader.loadFile(System.getProperty("user.home") + "/cost.ini");
		} catch(Exception e) {
			Functions.showExceptionMessage(null, e, "��������", "�������� ���� �� ������� ��� <b>main.ini</b>");
		}
		data = o instanceof HashObject ? (HashObject) o : new HashObject();
		if (!(data.get("���������") instanceof VectorObject)) data.put("���������", new VectorObject());
		if (!(data.get("�����������") instanceof VectorObject)) data.put("�����������", new VectorObject());
		if (!(data.get("���������") instanceof VectorObject)) data.put("���������", new VectorObject());
		if (!(data.get("�������������������������") instanceof HashObject)) data.put("�������������������������", new HashObject());
		if (!(data.get("���������") instanceof HashObject)) data.put("���������", new HashObject());
		if (!(data.get("���������������") instanceof IteratorHashObject)) data.put("���������������", new IteratorHashObject());
		costs = (IteratorHashObject) data.get("���������������");			// shortcut

		setSkin();
		try {
			for (int z = 0; z < args.length; z++)
				openCost(new File(args[z]).getCanonicalPath());
		} catch (IOException ex) {}

		ths = new MainFrame();
	}

	// ----- ActionListener ----- //

	@Override
	public void actionPerformed(ActionEvent e) {
		String ac = e.getActionCommand();
		JMenuItem j = (JMenuItem) e.getSource();

		// if we must output a draft order
		Map<String, String> env = new HashMap<String, String>();
		Map<String, Object> options = (HashObject) data.get("���������");
		if (Boolean.TRUE.equals(options.get("�������"))) env.put("one", "true");

		if (((JMenu) getMenuFromName("fexport")).isMenuComponent(j))
			options.put("�������", ac);
		else if (((JMenu) getMenuFromName("skins")).isMenuComponent(j)) {
			options.put("�������", ac);
			JOptionPane.showMessageDialog(this, "�� ������� �� ������� ���� �������������� �� ���������", "������ ��������", JOptionPane.INFORMATION_MESSAGE);
		} else if (((JMenu) getMenuFromName("costs")).isMenuComponent(j)) {
			costs.setPos(ac);
			updatePanels();
		} else if (ac == "openwith") {
			String editor = (String) options.get("������������");
			JFileChooser fc = new JFileChooser();
			if (editor != null) fc.setSelectedFile(new File(editor));
			fc.setDialogTitle("������� ����������� �������� ��� �� ������� �� ��������� ������");
			if(fc.showOpenDialog(this) == JFileChooser.APPROVE_OPTION) {
				File f = fc.getSelectedFile();
				if (f.exists()) options.put("������������", f.getPath());
				else {
					options.remove("������������");
					JOptionPane.showMessageDialog(this, "<html>��� ������� �� ���������:<br><b>" + f.getPath() + "</b>", "������������ ��������", JOptionPane.ERROR_MESSAGE);
				}
			}
		}
		else if (ac == "new") newCost();
		else if (ac == "open") openCost();
		else if (ac == "save") saveCost();
		else if (ac == "close") closeCost();
		else if (ac == "exit") dispatchEvent(new WindowEvent(this, WindowEvent.WINDOW_CLOSING));
		else if (ac == "cost") ExportReport.exportReport("cost.php", env);
		else if (ac == "taxis") ExportReport.exportReport("fe_tax.php");
		else if (ac == "provider") ExportReport.exportReport("fe_provider.php");
		else if (ac.startsWith("order_")) {
			final String[] a = { "������� ���������", "������" };
			Object b = JOptionPane.showInputDialog(this, "�������� ��� �� �� ���� � �������.", "�������", JOptionPane.QUESTION_MESSAGE, null, a, a[0]);
			if (b == null) return; else if (a[1].equals(b)) env.put("draft", "true");
			ExportReport.exportReport(ac.substring(6) + ".php", env);
		}
		else if (ac == "contest_proposal") ExportReport.exportReport("contest_proposal.php");
		else if (ac == "contest_record") ExportReport.exportReport("contest_record.php");
		else if (ac == "hold") ExportReport.exportReport("holds.php");
		else if (ac == "bills") ExportReport.exportReport("bills.php");
		else if (ac == "ticket") ExportReport.exportReport("ticket.php");
		else if (ac == "only_one") options.put("�������", !Boolean.TRUE.equals(options.get("�������")));
		else if (ac == "help_open") {
			try {
				BrowserLauncher.openURL(rootPath + "help/index.html");
			} catch(Exception ex) {
				Functions.showExceptionMessage(this, ex, "�������� ���� �������� ��� browser", null);
			}
		}
		else if (ac == "about") JOptionPane.showMessageDialog(this, "<html><center><b><font size=4>������������ �������</font><br><font size=3>������ 1.4.8</font></b></center><br>���������������: <b>������ ������ (��� 2002)</b><br>����� ������: <b>BSD</b><br>����������: <b>12 ��� 2013</b><br>������: <b>http://sourceforge.net/projects/ha-expenditure/</b>", getTitle(), JOptionPane.PLAIN_MESSAGE);
	}


	private static class OnlyOneInstance implements Runnable {
		private static ServerSocket ss;
		public static boolean check() {
			try {
				ss = new ServerSocket(666);
				new Thread(new OnlyOneInstance()).start();
				return true;
			} catch(Exception e) { return false; }
		}

		public static void send(byte[] a) {
			try {
				OutputStream s = new Socket("127.0.0.1", 666).getOutputStream();
				s.write(a);
				s.close();
			} catch(Exception e) {}
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