package cost;

import java.awt.*;
import java.util.ArrayList;
import javax.swing.*;
import tables.*;

public class Men extends JPanel implements ArrayTransmitter<Man> {
	static protected JComboBox men;
	public Men() {
		men = new JComboBox(new ComboDataModel(this, null));
		setLayout(new BorderLayout());
		add(new JScrollPane(new ResizableTable(new ResizableTableModel(this, new String[] { "������", "�������������", "������" }, new String[] { null, null, "<html>������ <font color=gray size=2>(������ �� �����)" }, Man.class), true, true)));
	}

	@Override
	public ArrayList<Man> getData() { return (ArrayList<Man>) MainFrame.data.get("���������"); }
}