package cost;

import common.*;

public class Material extends HashObject {
  public Material() {
    super.put("��������", 1d);
    super.put("������M�������", "�������");
  }
	public Material(BillItem i) {
		super.put("�����", i.get("�����"));
		super.put("������M�������", i.get("������M�������"));
		super.put("��������", i.get("��������"));
	}
	@Override
  public String toString() { return get("�����").toString(); }
	@Override
  public Object put(String key, Object value) {
    if (key.equals("��������") && value instanceof String)
      value = new Double(value.toString());
    return super.put(key, value);
  }
}
