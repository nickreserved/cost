package cost;

import java.awt.*;
import javax.swing.*;
import tables.*;

public class Providers extends JPanel implements DataTransmitter {
	static protected JComboBox providers;

	public Providers() {
		providers = new JComboBox(new ComboDataModel(this, null));
		setLayout(new BorderLayout());
		add(new JScrollPane(new ResizableTable(new ResizableTableModel(this, new String[]{"��������", "���", "���", "��������", "�.�.", "����", "���������"}, null, Provider.class), true, true)));
	}

	@Override
	public Object getData() { return MainFrame.data.get("�����������"); }
}