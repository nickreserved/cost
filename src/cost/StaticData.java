package cost;

import java.awt.*;
import javax.swing.*;
import common.*;
import tables.*;

public class StaticData extends JPanel implements DataTransmitter {
	public StaticData() {
		final String[] hdr = { "������ (����.)", "������ (����.)", "������� �����������",
				null, "�������� �����",	"���� � �����", null, "�������� (���������)",
				"�������� (���������)", "�.�.",	null, null, "����� ��������"
		};
		final String[] hash = { "���������������", "������", "������������������",
				"�������", "�������������", "����", "���������", "�����������������",
				"�����������������", "��", "�����", "���", "�������������"
		};
		Component[] cmp = new Component[hash.length];
		for (int z = hash.length - 3; z < hash.length; z++) cmp[z] = Men.men;
		setLayout(new BorderLayout());
		add(PropertiesTable.getScrolled(new PropertiesTableModel(hash, this, hdr), cmp, 130));
	}
	
	public Object getData() {
		Object c = MainFrame.costs.get();
		return c == null ? MainFrame.data.get("�������������������������") : c;
	}
}