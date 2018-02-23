package cost;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.UIManager.*;

public class MainFrame extends JFrame {
  public static Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();

  public Bills bills = new Bills(this);
  public StaticData staticData = new StaticData();
  public CostData cost = new CostData(this);

  JMenuItem newCost = new JMenuItem("��� ������");
  JMenuItem openCost = new JMenuItem("������� �������...");
  JMenuItem saveCost = new JMenuItem("���������� �������...");
  JMenuItem exit = new JMenuItem("������");
  JMenuItem exportCost = new JMenuItem("������");
  JMenuItem exportEpitropes = new JMenuItem("���������� ���������");
  JMenuItem exportDiabibastiko = new JMenuItem("������������ �������");
  JMenuItem exportParatash = new JMenuItem("������ ��������� ��������");
  JMenuItem exportBill = new JMenuItem("��������");
  JMenuItem exportEforia = new JMenuItem("������ ��");
  JMenuItem exportProvider = new JMenuItem("�������� �������� ��");
  JMenuItem exportReport = new JMenuItem("������ �������");
  JMenuItem exportHolds = new JMenuItem("������� ���������");

  public MainFrame() throws Exception {
    super("������������ �������");

    JTabbedPane mainTab = new JTabbedPane();
    mainTab.addTab("�������� �������", cost);
    mainTab.addTab("���������", bills);
    mainTab.addTab("���������� ��������", staticData);
    mainTab.addTab("�����������", new Providers(this));
    mainTab.addTab("���������", new Holds(this));
    mainTab.addTab("��������� �������", new Men(this));
    mainTab.addTab("�����������", about());
    getContentPane().add(mainTab);
    Color c = Color.decode("#b0d0b0");
    mainTab.setBackgroundAt(0, c);
    mainTab.setBackgroundAt(1, c);
    mainTab.setBackgroundAt(2, c);
    c = Color.decode("#e0e0b0");
    mainTab.setBackgroundAt(3, c);
    mainTab.setBackgroundAt(4, c);
    mainTab.setBackgroundAt(5, c);
    mainTab.setBackgroundAt(6, Color.decode("#b0d0e0"));

    newCost.addActionListener(cost);
    openCost.addActionListener(cost);
    saveCost.addActionListener(cost);
    exit.addActionListener(cost);
    exportCost.addActionListener(cost);
    exportEpitropes.addActionListener(cost);
    exportBill.addActionListener(cost);
    exportEforia.addActionListener(cost);
    exportProvider.addActionListener(cost);
    exportDiabibastiko.addActionListener(cost);
    exportReport.addActionListener(cost);
    exportHolds.addActionListener(cost);

    JMenu allhlografia = new JMenu("������������");
    allhlografia.add(exportEpitropes);
    allhlografia.add(exportParatash);
    allhlografia.add(exportDiabibastiko);
    JMenu file = new JMenu("������");
    file.add(newCost);
    file.addSeparator();
    file.add(openCost);
    file.add(saveCost);
    file.addSeparator();
    file.add(exit);
    JMenu export = new JMenu("�������");
    export.add(exportCost);
    export.addSeparator();
    export.add(allhlografia);
    export.addSeparator();
    export.add(exportBill);
    export.addSeparator();
    export.add(exportEforia);
    export.add(exportProvider);
    export.addSeparator();
    export.add(exportReport);
    export.add(exportHolds);
    JMenuBar jmb = new JMenuBar();
    jmb.add(file);
    jmb.add(export);
    this.setJMenuBar(jmb);

    setSize(635, 450);
    setLocation( (screenSize.width - getWidth()) / 2,
	     (screenSize.height - getHeight()) / 2);
    setVisible(true);
    enableEvents(AWTEvent.WINDOW_EVENT_MASK);
  }

  protected void processWindowEvent(WindowEvent e) {
    if (e.getID() == WindowEvent.WINDOW_CLOSING) {
      int a = JOptionPane.showConfirmDialog(null, "������ �� ����� � �������� ������;", "����������� ������",
					    JOptionPane.YES_NO_CANCEL_OPTION, JOptionPane.QUESTION_MESSAGE);
      boolean s = true;
      if (a == JOptionPane.YES_OPTION) s = cost.save();
      if (a == JOptionPane.CANCEL_OPTION || !s) return;
      System.exit(0);
    }
    super.processWindowEvent(e);
  }

  static Component about() {
      String s;
      try {
	s = LoadSaveFile.loadFileToString("cost/about.html");
      } catch (Exception e) {
	s = "��� ������� �� ������ <b>about.html</b>";
      }

      JEditorPane extra_info = new JEditorPane("text/html", s);
      JScrollPane scrlComment = new JScrollPane(extra_info, JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED,
						JScrollPane.HORIZONTAL_SCROLLBAR_NEVER);
      extra_info.setEditable(false);
      extra_info.setCaretPosition(0);
      return scrlComment;
  }


  static public void setSkin(String skin) {
    try {
      LookAndFeelInfo[] laf = UIManager.getInstalledLookAndFeels();
      for (int z = 0; z < laf.length; z++)
	if (laf[z].getName().equalsIgnoreCase(skin)) {
	  UIManager.setLookAndFeel(laf[z].getClassName());
	  return;
	}
      UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
    }
    catch(Exception e) {
    }
  }

  public static void main(String[] args) throws Exception {
    setSkin(args.length > 0 && !args[0].endsWith(".cost") ? args[0] : null);
    MainFrame m = new MainFrame();
    String a = null;
    if (args.length > 0 && args[0].endsWith(".cost")) a = args[0];
    else if (args.length > 1 && args[1].endsWith(".cost")) a = args[1];
    if (a != null) m.cost.loadFile(a);
  }
}