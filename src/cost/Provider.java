package cost;

import common.*;

public class Provider extends HashObject {
	public Provider() { super.put("�����", "�������"); } // backward compatibility
	@Override
  public String toString() { return get("��������").toString(); }
}