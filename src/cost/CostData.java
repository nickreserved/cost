package cost;

import java.awt.*;
import java.util.*;
import javax.swing.*;
import tables.*;

public class CostData extends JPanel implements DataTransmitter {
	public CostData() {
		final String[] hdr = { "����� �������", "�����������", "��� ��������", "��� ����������� ���������",
				null, null, null, null, null, "���������� ��������", "����� �����",
				"�������� ������ ��������", "�' ����� ������ ��������", "�' ����� ������ ��������",
				"�������� �����. �����. ���������", "�' ����� �����. �����. ���������", "�' ����� �����. �����. ���������",
		};
		final String[] hash = { "������������", "����������������", "�����������", "�����������",
				"������������", "����", "��", "��", "������", "������������������", "���������",
				"����������������������", "��������������������", "��������������������",
				"�����������������������������������", "���������������������������������", "���������������������������������"
		};
		final String[] cosT = { "��������� - ��������� - ��������", "��������� ����� �� ����� �������� � �������� ��� ������� � ��������������", "��������� ����� ��� ����������� ����������" };
		final String[] contesT = { "����� ����������", "��������� �����������", "�������� �����������" };
		Component[] cmp = new Component[hash.length];
		cmp[0] = new JComboBox(cosT);
		cmp[1] = new JComboBox(contesT);
		for (int z = hash.length - 7; z < hash.length; z++) cmp[z] = Men.men;
		setLayout(new BorderLayout());
		add(PropertiesTable.getScrolled(new PropertiesTableModel(hash, this, hdr), cmp, 210));
	}
	
	public Object getData() {
		Object o = MainFrame.costs.get(MainFrame.currentCost);
		return o instanceof Dictionary ? o : null;
	}
}