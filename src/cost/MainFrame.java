package cost;

import javax.swing.*;
import javax.swing.event.*;
import java.awt.*;
import java.awt.event.*;

public class MainFrame extends JFrame {
  public static Dimension screenSize = Toolkit.getDefaultToolkit().getScreenSize();

  public Bills bills = new Bills(this);
  public StaticData staticData = new StaticData();
  public CostData cost = new CostData(this);

  JMenuItem newCost = new JMenuItem("��� ������");
  JMenuItem openCost = new JMenuItem("������� �������...");
  JMenuItem saveCost = new JMenuItem("���������� �������...");
  JMenuItem exportCost = new JMenuItem("������");
  JMenuItem exportPlan = new JMenuItem("������");
  JMenuItem exportBill = new JMenuItem("��������");
  JMenuItem exportEforia = new JMenuItem("������ ��");
  JMenuItem exportProvider = new JMenuItem("�������� �������� ��");
  JMenuItem exportPreReport = new JMenuItem("������ ������������ �������");
  JMenuItem exportReport = new JMenuItem("������ ��������� �������");
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
    mainTab.addTab("�����������", new About());
    getContentPane().add(mainTab);

    newCost.addActionListener(cost);
    openCost.addActionListener(cost);
    saveCost.addActionListener(cost);
    exportCost.addActionListener(cost);
    exportPlan.addActionListener(cost);
    exportBill.addActionListener(cost);
    exportEforia.addActionListener(cost);
    exportProvider.addActionListener(cost);
    exportPreReport.addActionListener(cost);
    exportReport.addActionListener(cost);
    exportHolds.addActionListener(cost);

    JMenu file = new JMenu("������");
    file.add(newCost);
    file.add(openCost);
    file.add(saveCost);
    JMenu export = new JMenu("�������");
    export.add(exportCost);
    export.add(exportPlan);
    export.add(exportBill);
    export.add(exportEforia);
    export.add(exportProvider);
    export.add(exportPreReport);
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
      // Save something???
      System.exit(0);
    }
    super.processWindowEvent(e);
  }

  public static void main(String[] args) throws Exception {
    new MainFrame();
  }
}