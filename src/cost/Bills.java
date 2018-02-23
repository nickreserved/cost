package cost;

import java.util.*;
import java.awt.*;
import javax.swing.*;
import javax.swing.event.*;
import javax.swing.table.*;
import tables.*;
import common.*;
import java.awt.event.*;

public class Bills extends JPanel implements ListSelectionListener, ArrayTransmitter<Bill>, TableModelListener {
	static protected JComboBox cbMeasures = new JComboBox(new String[] { "�������", "lt", "Kgr", "ton", "mm", "cm", "<html>cm<sup>2", "<html>cm<sup>3", "m", "<html>m<sup>2", "<html>m<sup>3", "����", "�����", "������", "�����", "���������", "Km", "<html>Km<sup>2" });
	private final ResizableTableModel billModel;
	private final JTable tblBills;
	private String cost;

	public Bills() {
		ResizableTableModel billsModel = new ResizableTableModel(this, new String[] { "���������", "���������", "�����������", "�������������������������", "���������" }, new String[] { null, null, null, "���������", "��" }, Bill.class);
		billsModel.addTableModelListener(this);
		tblBills = new ResizableTable(billsModel, false, false);
		tblBills.getSelectionModel().addListSelectionListener(this);
		tblBills.setSelectionMode(ListSelectionModel.SINGLE_SELECTION);
		TableColumnModel cm = tblBills.getColumnModel();
		cm.getColumn(1).setCellEditor(new DefaultCellEditor(new JComboBox(new String[] { "��������� ������", "������ ���������", "����� ����� ��������" })));
		cm.getColumn(2).setCellEditor(new DefaultCellEditor(Providers.providers));
		cm.getColumn(3).setCellEditor(new DefaultCellEditor(Holds.holds));
		cm.getColumn(4).setCellEditor(new DefaultCellEditor(new JComboBox(new Byte[] { 4, 8, 0, 1, 3, 20 })));

		billModel = new ResizableTableModel((ArrayList) null, new String[] { "�����", "��������", "�����������", "������������", "���", "����M������M����", "�����������������" ,"������M�������"}, new String[] { null, null, "���� �������", "�������� ����", null, "���� ������� �� ���", "�������� ���� �� ���" ,"������ ��������"}, BillItem.class);
		final JTable billTable = new ResizableTable(billModel, true, true);
		cm = billTable.getColumnModel();
		JComboBox fpa = new JComboBox(new Byte[] { 23, 13, 16, 9, 5, 0 });
		fpa.setEditable(true);
		cm.getColumn(4).setCellEditor(new DefaultCellEditor(fpa));
		cbMeasures.setEditable(true);
		cm.getColumn(7).setCellEditor(new DefaultCellEditor(cbMeasures));
		billModel.addTableModelListener(this);

		// �������� �������� �������� ��� popup menu ��� �������� ������ ���� ��������
		JPopupMenu popupMenu = billTable.getComponentPopupMenu();
		popupMenu.addSeparator();
		JMenuItem item = new JMenuItem("��������� ����������� ������� ���� �������� �������",
				new ImageIcon(ClassLoader.getSystemResource("cost/import.png")));
		popupMenu.add(item);
		item.addActionListener(
				new ActionListener() {
					@Override
					public void actionPerformed(ActionEvent e) {
						int rows[] = billTable.getSelectedRows();
						ArrayList<BillItem> items = billModel.getData();
						ArrayList<Material> materials = new ArrayList();
						for (int row : rows)
							if (row < items.size()) materials.add(new Material(items.get(row)));
						try {
						((Works) ((JTabbedPane) MainFrame.ths.getContentPane().getComponent(0))
								.getComponentAt(3)).addMaterialToCurrentWork(materials);
						} catch(Exception ex) {
							JOptionPane.showMessageDialog(MainFrame.ths, "��� ������� ���������� ������� ��� �� ���������� �����.\n" +
									"�������� ����� ��� ������� ���� ������� ��������� ��� ���� ��������� �����, ��� �� ���������, �� ����.",
									"���������� �������", JOptionPane.ERROR_MESSAGE);
						}
					}
				});

		setLayout(new BorderLayout());
		JSplitPane sp = new JSplitPane(JSplitPane.VERTICAL_SPLIT, new JScrollPane(tblBills), new JScrollPane(billTable));
		sp.setDividerSize(3);
		sp.setDividerLocation(75);
		add(sp, BorderLayout.CENTER);
		add(PropertiesTable.getBoxed(new PropertiesTable(new ReportTableModel(), null)), BorderLayout.SOUTH);
	}

	@Override
	public ArrayList<Bill> getData() {
		Cost c = (Cost) MainFrame.costs.get();
		return c == null ? null : (ArrayList<Bill>) c.get("���������");
	}

	@Override
	public void tableChanged(TableModelEvent e) {
		ArrayList v = (ArrayList) getData();
		int cb = tblBills.getSelectionModel().getLeadSelectionIndex();
		if (v == null || cb == -1 || cb >= v.size()) return;
		((Bill) v.get(cb)).recalculate();
		repaint();
	}

	@Override
	public void valueChanged(ListSelectionEvent e) {
		ArrayList v = (ArrayList) getData();
		int cb = tblBills.getSelectionModel().getLeadSelectionIndex();
		billModel.setData(cb < 0 || cb >= v.size() ? null : (ArrayList) ((Map) v.get(cb)).get("����"));
	}

	@Override
	public void paint(Graphics g) {
		if (cost != MainFrame.costs.getPos()) {
			cost = MainFrame.costs.getPos();
			valueChanged(null);
			((ResizableTableModel) tblBills.getModel()).fireTableRowsDeleted(10000, 10000);
		}
		super.paint(g);
	}

	private class ReportTableModel extends PropertiesTableModel {
		public ReportTableModel() {
			super(new String[] { "����������", "�������������", "������������", "����������������������", "��������", "��������", "����������������", null, null, null, null, null, null, null }, null, new String[] { "������ ����", "���", null, "���������", null, "��", "��������" }, new String[] { "������ ���������", "��� �� ���������" });
		}
		@Override
		public boolean isCellEditable(int row, int col) { return false; }
		@Override
		public Object getValueAt(int row, int col) {
			try {
				Object t, o = null;
				VectorObject bv = (VectorObject) ((ResizableTableModel) tblBills.getModel()).getData();
				int cb = tblBills.getSelectionModel().getLeadSelectionIndex();
				switch (col) {
					case -1: return super.getValueAt(row, col);
					case 0:
						if (cb == -1 || cb >= bv.size()) return null;
						o = ((Bill) bv.get(cb)).get(getHash()[row]);
						if ((row == 1 || row == 3) && o != null)
							o = ((Map) o).get("������");
						break;
					case 1:
						o = 0d;
        for (Object bv1 : bv) {
          t = ((Bill) bv1).get(getHash()[row]);
          if ((row == 1 || row == 3) && t != null)
            t = ((Map) t).get("������");
          o = M.round(M.add((Number) o, (Number) t), 2);
        }
				}
				if (!(o instanceof Number) || ((Number) o).doubleValue() != 0) return o;
			} catch(Exception e) {}
			return null;
		}
	}
}