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
  public boolean equals(Object o) { return o instanceof BillItem && toString().equals(o.toString()); }

  public boolean isEmpty() {
    return super.get("�����") == null && super.get("�����������") == null &&
	super.get("��������") == null;
  }

  public Object get(Object key) {
    Object o = super.get(key);
    if (o != null) return o;
    if (key.equals("������������"))
      o = M.round(M.mul((Number) super.get("�����������"), (Number) super.get("��������")), 2);
    else if (key.equals("����M������M����"))
      o = M.round(M.mul((Number) super.get("�����������"),
		    (100 + ((Number) super.get("���")).doubleValue()) / (double) 100), 4);
    else if (key.equals("�����������������"))
      o = M.round(M.mul((Number) get("������������"),
		    (100 + ((Number) super.get("���")).doubleValue()) / (double) 100), 2);
    super.put("$" + key, o);
    return o;
  }

  public Object put(Object key, Object value) {
    if (value instanceof String) value = super.fromString(key, value.toString());
    if (value instanceof Number && ((Number) value).doubleValue() == 0 && !key.equals("���")) value = null;
    if (key.equals("������������")) {
      Number d = value == null ? null : M.round(M.div((Number) value, (Number) super.get("��������")), 4);
      super.put("�����������", d);
    } else if (key.equals("�����������������")) {
      Number d = value == null ? null : M.round(M.div((Number) value, M.mul(
          (Number) super.get("��������"), 1 + ((Number) super.get("���")).doubleValue() / 100)), 4);
      super.put("�����������", d);
    } else if (key.equals("����M������M����")) {
      Number d = value == null ? null : M.round(M.div((Number) value,
          1 + ((Number) super.get("���")).doubleValue() / 100), 4);
      super.put("�����������", d);
    } else
      return super.put(key, value);
    return get(key);
  }
}