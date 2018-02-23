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
		super.put("���", (byte) 23);
		super.put("��������", 1.0);
		super.put("������M�������", "�������");
	}

	@Override
	public String toString() { return super.get("�����").toString(); }

	private void recalculate() {
		byte fpa = ((Number) super.get("���")).byteValue();
		Number Many = (Number) super.get("��������");
		double many = Many == null ? 0.0 : Many.doubleValue();
		Double Cost = (Double) super.get("�����������");
		double cost = Cost == null ? 0.0 : Cost;
		if (cost != 0 && many != 0) {
			getDynamic().put("������������", Functions.round(cost * many, 3));
			getDynamic().put("�����������������", Functions.round(cost * many * (1 + fpa / 100.0), 2));
		} else {
			getDynamic().remove("������������");
			getDynamic().remove("�����������������");
		}
		if (cost != 0)
			getDynamic().put("����M������M����", Functions.round(cost * (1 + fpa / 100.0), 4));
		else
			getDynamic().remove("����M������M����");
	}

	@Override
	public Object put(String key, Object value) {
		if (value instanceof String) value = super.fromString(key, value.toString());
		if (value instanceof Number && ((Number) value).doubleValue() == 0 && !key.equals("���")) value = null;
		double d;
		switch (key) {
			case "������������": d = ((Number) super.get("��������")).doubleValue(); break;
			case "�����������������":
				d = ((Number) super.get("��������")).doubleValue() *
						(1 + ((Number) super.get("���")).byteValue() / 100.0);
				break;
			case "����M������M����":
				d = 1 + ((Number) super.get("���")).byteValue() / 100.0;
				break;
			default:
				Object o = super.put(key, value);
				recalculate();
				return o;
		}
		d = Functions.round(((Double) value) / d, 4);
		super.put("�����������", d);
		recalculate();
		return get(key);
	}
}