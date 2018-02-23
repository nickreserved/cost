package cost;

import java.util.*;

import java.awt.*;
import javax.swing.*;
import javax.swing.event.*;
import javax.swing.table.*;

import tables.*;

public class Bills extends JPanel implements ListSelectionListener, DataTransmitter,
    TableModelListener {
  private static final String[] itemHeader = { "�����", "��������", "���� �������", "�������� ����",
      "���", "���� ������� �� ���", "�������� ���� �� ���" ,"������ ��������"};
  private static final String[] itemHash = { "�����", "��������", "�����������", "������������",
      "���", "����M������M����", "�����������������" ,"������M�������"};

  protected static final String[] measures = { "�������", "lt", "Kgr", "cm", "cm^2", "cm^3", "m", "m^2",
      "m^3", "����", "�����", "������", "�����", "���������", "Km", "Km^2" };
  protected static final Number[] fpaList = { new Byte((byte) 36), new Byte((byte) 19), new Byte((byte) 9), new Byte((byte) 0) };

  private static final String[] billHeader = { "���������", "�����", "���������", "�����������",
      "���������", "��" };
  private static final String[] billHash = { "���������", "�����", "���������", "�����������",
      "�������������������������", "���������" };

  protected static final Number[] feList = { new Byte((byte) 8), new Byte((byte) 4), new Byte((byte) 3), new Byte((byte) 1), new Byte((byte) 0) };
  private static final String[] billTypes = { "���������", "��/���", "�������" };
  private static final String[] categories = { "��������� ������", "������ ���������", "����� ����� ��������" };

  private static final String[] propertiesHeader = { "", "������ ���������", "��� �� ���������" };
  private static final String[][] propertiesNames = {
      { ":������ ����", "����������", "����������" },
      { ":���", "�������������", "�������������" },
      { ":������������", "������������", "������������" },
      { ":���������", "����������������������", "����������������������" },
      { ":��������", "��������", "��������" },
      { ":��", "��������", "��������" },
      { ":��������", "����������������", "����������������" }
  };

  private static int currentBill = -1;

  private static ResizableTableModel billsModel;
  private static ResizableTableModel billModel;
  private static PropertiesTableModel propertiesModel;
  private static JTable billsTable;

  protected JComboBox cbMeasures = new JComboBox(measures);

  public Bills() {
    billsModel = new ResizableTableModel(this, billHash, billHeader, Bill.class);
    billsTable = new JTable(billsModel);
    billsTable.getSelectionModel().addListSelectionListener(this);
    billsModel.addTableModelListener(this);
    billsTable.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
    TableColumnModel cm = billsTable.getColumnModel();
    cm.getColumn(1).setCellEditor(new DefaultCellEditor(new JComboBox(billTypes)));
    cm.getColumn(2).setCellEditor(new DefaultCellEditor(new JComboBox(categories)));
    cm.getColumn(3).setCellEditor(new DefaultCellEditor(Providers.providers));
    cm.getColumn(4).setCellEditor(new DefaultCellEditor(Holds.holds));
    cm.getColumn(5).setCellEditor(new DefaultCellEditor(new JComboBox(feList)));

    billModel = new ResizableTableModel((Vector) null, itemHash, itemHeader, BillItem.class);
    JTable billTable = new JTable(billModel);
    cm = billTable.getColumnModel();
    cm.getColumn(4).setCellEditor(new DefaultCellEditor(new JComboBox(fpaList)));
    cm.getColumn(7).setCellEditor(new DefaultCellEditor(cbMeasures));
    billTable.getSelectionModel().addListSelectionListener(this);
    billModel.addTableModelListener(this);
    cbMeasures.setEditable(true);

    propertiesModel = new ReportTableModel();
    final int[] d = { 85 };
    JTable propertiesTable = new PropertiesTable(propertiesModel, d, null);

    setLayout(new BorderLayout());
    JSplitPane sp = new JSplitPane(JSplitPane.VERTICAL_SPLIT,
				   new JScrollPane(billsTable),
				   new JScrollPane(billTable));
    sp.setDividerSize(3);
    sp.setDividerLocation(75);
    add(sp, BorderLayout.CENTER);
    Box bv1 = Box.createVerticalBox();
    bv1.add(propertiesTable.getTableHeader());
    bv1.add(propertiesTable);
    add(bv1, BorderLayout.SOUTH);
  }

  public Object getData() {
    if (MainFrame.currentCost == null) return null;
    Object o = MainFrame.costs.get(MainFrame.currentCost);
    if (!(o instanceof Dictionary)) return null;
    Object a = ((Dictionary) o).get("���������");
    if (!(a instanceof BillVector)) {
      ((Dictionary) o).put("���������", a = new BillVector());
      billsModel.fireTableDataChanged();
    }
    return a;
  }

  public void tableChanged(TableModelEvent e) {
    BillVector v = (BillVector) getData();
    if (v == null) return;
    v.removeTemporary();
    if (currentBill != -1) {
      Bill b = (Bill) v.get(currentBill);
      b.removeTemporary();
      if (billsModel.equals(e.getSource())) {
        b.setFe();
        b.setFpa();
        billModel.fireTableDataChanged();
      }
    }
  }

  public void valueChanged(ListSelectionEvent e) {
    int a = billsTable.getSelectedRow();
    BillVector v = (BillVector) getData();
    if (a != -1) {
      if (v.size() > a) {
	currentBill = a;
	Bill b = (Bill) v.get(a);
	billModel.setData((Vector) b.get("����"));
      } else {
	currentBill = -1;
	billModel.setData((Vector) null);
      }
    }
    propertiesModel.fireTableDataChanged();
  }

  public void updateObject() {
    currentBill = -1;
    billsModel.fireTableDataChanged();
    billModel.setData((Vector) null);
    propertiesModel.fireTableDataChanged();
  }


  // =============================== ReportTableModel ===================================== //

  protected class ReportTableModel extends PropertiesTableModel {
    public ReportTableModel() {
      super(propertiesNames, (Dictionary) null, propertiesHeader);
    }
    public boolean isCellEditable(int row, int col) { return false; }
    public Object getValueAt(int row, int col) {
      try {
        Object o = null;
        BillVector bv = (BillVector) billsModel.getData();
        switch (col) {
          case 0: return super.getValueAt(row, col);
          case 1:
            if (currentBill == -1 || currentBill >= bv.size()) return null;
            Bill b = (Bill) bv.get(currentBill);
            o = b.get(propertiesNames[row][col]);
            break;
          case 2: o = bv.get(propertiesNames[row][col]);
        }
        if (row == 1 || row == 3) o = ((Map) o).get("������");
        if (!(o instanceof Number) || ((Number) o).doubleValue() != 0) return o;
      } catch(Exception e) {}
      return null;
    }
  }
}