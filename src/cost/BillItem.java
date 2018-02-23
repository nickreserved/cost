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
		super.put("���", new Byte((byte) 19));
		super.put("��������", new Double(1));
		super.put("������M�������", "�������");
	}
	
	public String toString() { return super.get("�����").toString(); }
	
	public boolean isEmpty() {
		return super.get("�����") == null && super.get("�����������") == null && super.get("��������") == null;
	}
	
	private void recalculate() {
		Number nFpa = (Number) super.get("���");
		if (nFpa == null) super.put("���", nFpa = new Byte((byte) 0));
		double many = M.safeNumber2double((Number) super.get("��������"));
		double cost = M.safeNumber2double((Number) super.get("�����������"));
		double fpa = nFpa.doubleValue();
		if (cost != 0 && many != 0) {
			super.put("$������������", M.round(cost * many, 2));
			super.put("$�����������������", M.round(cost * many * (1 + fpa / 100), 2));
		} else {
			super.remove("$������������");
			super.remove("$�����������������");
		}
		if (cost != 0)
			super.put("$����M������M����", M.round(cost * (1 + fpa / 100), 4));
		else
			super.remove("$����M������M����");
	}
	
	public Object put(String key, Object value) {
		if (value instanceof String) value = super.fromString(key, value.toString());
		if (value instanceof Number && ((Number) value).doubleValue() == 0 && !key.equals("���")) value = null;
		if (key.equals("������������")) {
			Number d = M.round(M.div((Number) value, (Number) super.get("��������")), 4);
			super.put("�����������", d);
		} else if (key.equals("�����������������")) {
			Number d = M.round(M.div((Number) value, M.mul((Number) super.get("��������"),
					1 + ((Number) super.get("���")).doubleValue() / 100)), 4);
			super.put("�����������", d);
		} else if (key.equals("����M������M����")) {
			Number d = M.round(M.div((Number) value, 1 + ((Number) super.get("���")).doubleValue() / 100), 4);
			super.put("�����������", d);
		} else {
			Object o = super.put(key, value);
			recalculate();
			return o;
		}
		recalculate();
		return get(key);
	}
}