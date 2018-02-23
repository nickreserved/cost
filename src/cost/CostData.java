package cost;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import tables.*;

public class CostData extends JPanel implements DataTransmitter {
	public CostData(ItemListener il) {
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
		JComboBox[] cmp = new JComboBox[hash.length];
		cmp[0] = new JComboBox(cosT);
		cmp[1] = new JComboBox(contesT);
		cmp[0].addItemListener(il);
		cmp[1].addItemListener(il);
		for (int z = hash.length - 7; z < hash.length; z++) cmp[z] = Men.men;
		setLayout(new BorderLayout());
		add(PropertiesTable.getScrolled(new PropertiesTableModel(hash, this, hdr), cmp, 190));
	}
	public Object getData() { return MainFrame.costs.get(); }
}