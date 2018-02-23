package cost;

import java.awt.*;
import java.util.*;
import javax.swing.*;
import common.*;
import tables.*;

public class StaticData extends JPanel implements DataTransmitter {
  public StaticData() {
    final String[][] hash = {
	{ ":������ (����.)", "���������������" },
	{ ":������ (����.)", "������" },
	{ ":�����������", "�����������" },
	{ ":������� (����.)", "����������������" },
	{ ":������� (����.)", "�������" },
	{ ":�������� �����", "�������������" },
	{ ":���� � �����", "����" },
	{ ":�������", "�������" },
	{ ":���������", "���������" },
	{ ":�������� (���������)", "�����������������" },
	{ ":�������� (���������)", "�����������������" },
	{ ":�.�.", "��" },
	{ ":��� �������", "����������" },
	{ ":��� �������", "���" },
	{ ":�����", "�����" },
	{ ":���", "���" },
	{ ":����� ��������", "�������������" },
	{ ":������", "������" },
    };
    final int[] d = { 130 };
    Component[][] cmp = new Component[hash.length][2];
    for (int z = hash.length - 4; z < hash.length; z++) cmp[z][1] = Men.men;
    setLayout(new BorderLayout());
    add(new JScrollPane(new PropertiesTable(new PropertiesTableModel(hash, this, null), d, cmp)));
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