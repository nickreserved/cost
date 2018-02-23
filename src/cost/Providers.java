package cost;

import java.awt.*;
import javax.swing.*;
import javax.swing.table.*;
import tables.*;

public class Providers extends JPanel implements DataTransmitter {
	static protected JComboBox providers;

	public Providers() {
		providers = new JComboBox(new ComboDataModel(this, null));
		setLayout(new BorderLayout());
		ResizableTable rt = new ResizableTable(new ResizableTableModel(this, new String[]{"��������", "�����", "���", "���", "��������", "�.�.", "����", "���������"}, null, Provider.class), true, true);
		add(new JScrollPane(rt));
		TableColumnModel cm = rt.getColumnModel();
		cm.getColumn(1).setCellEditor(new DefaultCellEditor(new JComboBox(new String[] { "�������", "�������", "�������", "�����������" })));
	}

	@Override
	public Object getData() { return MainFrame.data.get("�����������"); }
}