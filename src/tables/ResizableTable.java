package tables;

import java.awt.*;
import java.util.*;
import javax.swing.*;
import java.awt.event.*;

public class ResizableTable extends JTable
		implements ActionListener, KeyListener, MouseListener {
	public ResizableTable(ResizableTableModel rtm, boolean insert, boolean sort) {
		super(rtm);

		// Popup menu ��� �������� ��� �������� �������
		JPopupMenu popupMenu = new JPopupMenu();
		if (insert) {
			JMenuItem item = new JMenuItem("�������� ����� �������",
					new ImageIcon(ClassLoader.getSystemResource("cost/new.png")));
			item.addActionListener(this);
			item.setActionCommand("insert");
			item.setAccelerator(KeyStroke.getKeyStroke(KeyEvent.VK_INSERT, 0));
			popupMenu.add(item);
		}
		JMenuItem item = new JMenuItem("�������� ����������� �������",
				new ImageIcon(ClassLoader.getSystemResource("cost/close.png")));
		item.addActionListener(this);
		item.setActionCommand("delete");
		item.setAccelerator(KeyStroke.getKeyStroke(KeyEvent.VK_DELETE, 0));
		popupMenu.add(item);
		setComponentPopupMenu(popupMenu);

		addMouseListener(this);
		addKeyListener(this);
		
		if (sort) getTableHeader().addMouseListener(new MouseAdapter() {
				// �������� ���� �� ��� ����� ���� ����������� ��� ������, ������������ � ������������ �����
				@Override
					public void mouseClicked(MouseEvent e) {
						int a = convertColumnIndexToModel(getTableHeader().columnAtPoint(e.getPoint()));
						ResizableTableModel model = (ResizableTableModel) getModel();
						ArrayList data = model.getData();
						final String sortHeader = model.hash[a];
						if (data != null)
							Collections.sort(data,
								// ���������� ��� �������� ���� �� ����� ��� ������ ����, ������� �����
								new Comparator<Map>() {
									@Override
									public int compare(Map a, Map b) {
										Object aa = a.get(sortHeader);
										Object bb = b.get(sortHeader);
										if (aa instanceof Comparable)
											return bb != null && bb.getClass().equals(aa.getClass()) ?
												((Comparable) aa).compareTo((Comparable) bb) : 1;
										else
											return bb instanceof Comparable ? -1 : 0;
									}
								});
					}
				});
	}
	
	@Override
	public void keyPressed(KeyEvent e) {
		if (e.getKeyCode() == KeyEvent.VK_INSERT &&
				"insert".equals(((JMenuItem) getComponentPopupMenu().getComponent(0)).getActionCommand())) {
			e.consume();
			actionPerformed(new ActionEvent(this, ActionEvent.ACTION_PERFORMED, "insert"));
		} else if (e.getKeyCode() == KeyEvent.VK_DELETE) {
			e.consume();
			actionPerformed(new ActionEvent(this, ActionEvent.ACTION_PERFORMED, "delete"));
		}
	}
	@Override
	public void keyReleased(KeyEvent e) {}
	@Override
	public void keyTyped(KeyEvent e) {}

	@Override
	public void mousePressed(MouseEvent e) {
		// ��� ���� ���� ����������� �� popup menu ��� ������ �� �����
		// ���������� ��� ������ ����������.
		if (e.getButton() == MouseEvent.BUTTON3 && this.getSelectedRow() == -1) {
        Point point = e.getPoint();
        int currentRow = rowAtPoint(point);
        setRowSelectionInterval(currentRow, currentRow);
		}
	}
	@Override
	public void mouseReleased(MouseEvent e) {}
	@Override
	public void mouseExited(MouseEvent e) {}
	@Override
	public void mouseEntered(MouseEvent e) {}
	@Override
	public void mouseClicked(MouseEvent e) {}

	@Override
	public void actionPerformed(ActionEvent e) {
		String ac = e.getActionCommand();
		if ("insert".equals(ac)) {
			ResizableTableModel rtm = (ResizableTableModel) getModel();
			ArrayList v = rtm.getData();
			int a = getSelectedRow();
			if (a >= 0 && a < v.size() && v.get(a) != null && (a == 0 || v.get(a - 1) != null)) {
				v.add(a, null);
				rtm.fireTableDataChanged();
			}
		} else if ("delete".equals(ac)) {
			ResizableTableModel rtm = (ResizableTableModel) getModel();
			ArrayList v = rtm.getData();
			int[] a = getSelectedRows();
			boolean chk = false;
			boolean yes = false;
			for (int z = a.length - 1; z >= 0; z--)
				if (a[z] >= 0 && a[z] < v.size()) {
				if (v.get(a[z]) != null && !chk) {
					chk = true;
					if (JOptionPane.YES_OPTION == JOptionPane.showConfirmDialog(this,
							"�������� �������� ��� ��� ����� ������. ������ �� ��� ��������;",
							"�������� ��������", JOptionPane.YES_NO_OPTION, JOptionPane.WARNING_MESSAGE))
						yes = true;
				}
				if (v.get(a[z]) == null || yes) v.remove(a[z]);
				}
			rtm.fireTableDataChanged();
		}
	}
}
