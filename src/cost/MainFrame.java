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
				"committee", "mail", null, "���������� ���������",
					"committee_draft", "committee", null, "������",
					"committee_nodraft", "committee", null, "������� ���������",
				"route_slip", "mail", null, "������������ �������",
					"route_slip_draft", "route_slip", null, "������",
					"route_slip_nodraft", "route_slip", null, "������� ���������",
				"prereport", "mail", null, "������ ������������ �������",
					"prereport_draft", "prereport", null, "������",
					"prereport_nodraft", "prereport", null, "������� ���������",
			"other", "export", null, "�������",
				"hold", "other", null, "������� ���������",
				"bills", "other", null, "����� ����������",
				"ticket", "other", null, "�������� ��� �����������",
		"options", null, null, "���������",
			"skins", "options", "skins", "������� ",
		"costs", null, null, "�������",
		"help", null, null, "�������",
			"help_open", "help", "help", "�������"
	};
	private static JMenuItem[] menu = new JMenuItem[mnu.length / 4];
	
	public static Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();
	public static String rootPath;
	static protected HashObject data;
	static protected IteratorHashObject costs;
	static protected MainFrame ths;
	
	public MainFrame() {
		super("������������ ������� 1.2.0");
		setIconImage(new ImageIcon(ClassLoader.getSystemResource("cost/app.png")).getImage());
		
		Providers prov = new Providers();
		Men men = new Men();
		Holds holds = new Holds();
		Contents contents = new Contents();
			
		JTabbedPane mainTab = new JTabbedPane();
		mainTab.addTab("�������� �������", new CostData(contents));
		mainTab.addTab("���������", new Bills());
		mainTab.addTab("����� �����������", contents);
		mainTab.addTab("���������� ��������", new StaticData());
		mainTab.addTab("�����������", prov);
		mainTab.addTab("���������", holds);
		mainTab.addTab("��������� �������", men);
		
		getContentPane().add(mainTab);
		Color c = Color.decode("#b0d0b0");
		mainTab.setBackgroundAt(0, c);
		mainTab.setBackgroundAt(1, c);
		mainTab.setBackgroundAt(2, c);
		c = Color.decode("#e0e0b0");
		mainTab.setBackgroundAt(4, c);
		mainTab.setBackgroundAt(5, c);
		mainTab.setBackgroundAt(6, c);
		
		updatePanels();
		
		setJMenuBar(createMenus(new JMenuBar()));
		updateMenus();
		addOptionsMenu();
		
		setSize(635, 450);
		setLocation((screenSize.width - getWidth()) / 2, (screenSize.height - getHeight()) / 2);
		setVisible(true);
		enableEvents(AWTEvent.WINDOW_EVENT_MASK);
	}
	
	private final JMenuBar createMenus(JMenuBar jtb) {
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
	
	static private final JMenuItem getMenuFromName(String s) {
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
			JFileChooser fc = new JFileChooser();
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
		j.setBackgroundAt(3, Color.decode(costs.getPos() == null ? "#e0e0b0" : "#b0d0b0"));
		for (int z = 0; z < 3; z++)
			j.setEnabledAt(z, costs.getPos() != null);
		if (costs.getPos() == null && j.getSelectedIndex() < 3) j.setSelectedIndex(3);
		repaint();
	}
	
	private void updateMenus() {
		getMenuFromName("save").setEnabled(costs.getPos() != null);
		getMenuFromName("close").setEnabled(costs.getPos() != null);
		JMenu window = (JMenu) getMenuFromName("costs");
		window.setEnabled(costs.getPos() != null);
		JMenu export = (JMenu) getMenuFromName("export");
		export.setEnabled(costs.getPos() != null);
		
		if (costs.getPos() != null) {
			window.removeAll();
			ButtonGroup btg = new ButtonGroup();
			Enumeration en = costs.keys();
			while (en.hasMoreElements()) {
				String m = en.nextElement().toString();
				JRadioButtonMenuItem jmi = new JRadioButtonMenuItem(new File(m).getName(), m.equals(costs.getPos()));
				jmi.addActionListener(this);
				jmi.setActionCommand(m);
				btg.add(jmi);
				window.add(jmi);
			}
		}
	}
	
	protected void processWindowEvent(WindowEvent e) {
		if (e.getID() == WindowEvent.WINDOW_CLOSING) {
			try {
				LoadSaveFile.save(rootPath + "main.ini", data);
			} catch(Exception ex) {
				if (JOptionPane.NO_OPTION == JOptionPane.showConfirmDialog(this, "<html>�������� ���� ��� ���������� ��� <b>main.ini</b>.<br>�� ������ �o ���������;", "�����������", JOptionPane.YES_NO_OPTION, JOptionPane.WARNING_MESSAGE))
					return;
			}
			System.exit(0);
		}
		super.processWindowEvent(e);
	}
	
	public void addOptionsMenu() {
		JMenuItem skins = getMenuFromName("skins");
		LookAndFeelInfo[] laf = UIManager.getInstalledLookAndFeels();
		String s = (String) ((HashObject) data.get("���������")).get("�������");
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
			o = TreeFileLoader.loadFile(rootPath + "main.ini");
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
	
	public void actionPerformed(ActionEvent e) {
		String ac = e.getActionCommand();
		JMenuItem j = (JMenuItem) e.getSource();
		
		// if we must output a draft order
		Map<String, String> env = new Hashtable();
		env.put("draft", "true");
		
		if (((JMenu) getMenuFromName("skins")).isMenuComponent(j)) {
			((HashObject) data.get("���������")).put("�������", ac);
			JOptionPane.showMessageDialog(this, "�� ������� �� ������� ���� �������������� �� ���������", "������ ��������", JOptionPane.INFORMATION_MESSAGE);
		} else if (((JMenu) getMenuFromName("costs")).isMenuComponent(j)) {
			costs.setPos(ac);
			updatePanels();
		} else if (ac == "new") newCost();
		else if (ac == "open") openCost();
		else if (ac == "save") saveCost();
		else if (ac == "close") closeCost();
		else if (ac == "exit") dispatchEvent(new WindowEvent(this, WindowEvent.WINDOW_CLOSING));
		else if (ac == "cost") ExportReport.exportReport("templates/cost.php");
		else if (ac == "taxis") ExportReport.exportReport("templates/fe_tax.php");
		else if (ac == "provider") ExportReport.exportReport("templates/fe_provider.php");
		else if (ac == "prereport_draft") ExportReport.exportReport("templates/prereport.php", env);
		else if (ac == "prereport_nodraft") ExportReport.exportReport("templates/prereport.php");
		else if (ac == "hold") ExportReport.exportReport("templates/holds.php");
		else if (ac == "bills") ExportReport.exportReport("templates/bills.php");
		else if (ac == "ticket") ExportReport.exportReport("templates/ticket.php");
		else if (ac == "committee_draft") ExportReport.exportReport("templates/order.php", env);
		else if (ac == "committee_nodraft") ExportReport.exportReport("templates/order.php");
		else if (ac == "route_slip_draft") ExportReport.exportReport("templates/route_slip.php", env);
		else if (ac == "route_slip_nodraft") ExportReport.exportReport("templates/route_slip.php");
		else if (ac == "help_open") {
			try {
				BrowserLauncher.openURL(rootPath + "help/index.html");
			} catch(Exception ex) {
				Functions.showExceptionMessage(this, ex, "�������� ���� �������� ��� browser", null);
			}
		}
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