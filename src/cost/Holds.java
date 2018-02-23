package cost;

import java.awt.*;
import javax.swing.*;
import tables.*;

public class Holds extends JPanel implements DataTransmitter {
	static protected JComboBox holds;
	private static final String[] header = { "���", "���", "���", "������", "����", "���", "�����", "������", "���������", "���", "������" };
	
	public Holds() {
		holds = new JComboBox(new ComboDataModel(this, new Hold()));
		setLayout(new BorderLayout());
		add(new JScrollPane(new ResizableTable(new ResizableTableModel(this, header, header, Hold.class), false)));
	}
	
	public Object getData() { return MainFrame.data.get("���������"); }
}