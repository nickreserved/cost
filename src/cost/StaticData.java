package cost;

import java.awt.*;
import java.util.*;
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
		Object o = MainFrame.currentCost == null ? null : MainFrame.costs.get(MainFrame.currentCost);
		if (o instanceof Dictionary) return o;
		if (!(MainFrame.data instanceof HashObject)) MainFrame.data = new HashObject();
		o = MainFrame.data.get("�������������������������");
		if (!(o instanceof HashObject))
			MainFrame.data.put("�������������������������", o = new HashObject());
		return o;
	}
}