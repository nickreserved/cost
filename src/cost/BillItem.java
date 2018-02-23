package cost;

import common.*;

public class BillItem extends HashString2Object {
	public BillItem() {
		classes.put("���", Byte.class);
		classes.put("��������", Double.class);
		classes.put("�����������", Double.class);
		classes.put("������������", Double.class);
		classes.put("����M������M����", Double.class);
		classes.put("�����������������", Double.class);
		super.put("���", 23);
		super.put("��������", 1);
		super.put("������M�������", "�������");
	}

	@Override
	public String toString() { return super.get("�����").toString(); }

	private void recalculate() {
		Number nFpa = (Number) super.get("���");
		if (nFpa == null) super.put("���", nFpa = 0);
		double many = M.safeNumber2double((Number) super.get("��������"));
		double cost = M.safeNumber2double((Number) super.get("�����������"));
		double fpa = nFpa.doubleValue();
		if (cost != 0 && many != 0) {
			getDynamic().put("������������", M.round(cost * many, 3));
			getDynamic().put("�����������������", M.round(cost * many * (1 + fpa / 100), 2));
		} else {
			getDynamic().remove("������������");
			getDynamic().remove("�����������������");
		}
		if (cost != 0)
			getDynamic().put("����M������M����", M.round(cost * (1 + fpa / 100), 4));
		else
			getDynamic().remove("����M������M����");
	}

	@Override
	public Object put(String key, Object value) {
		if (value instanceof String) value = super.fromString(key, value.toString());
		if (value instanceof Number && ((Number) value).doubleValue() == 0 && !key.equals("���")) value = null;
		Number d;
		switch (key) {
			case "������������": d = (Number) super.get("��������"); break;
			case "�����������������": d = M.mul((Number) super.get("��������"),
						1 + ((Number) super.get("���")).doubleValue() / 100);
				break;
			case "����M������M����":
				d = 1 + ((Number) super.get("���")).doubleValue() / 100;
				break;
			default:
				Object o = super.put(key, value);
				recalculate();
				return o;
		}
		d = M.round(M.div((Number) value, d), 4);
		super.put("�����������", d);
		recalculate();
		return get(key);
	}
}