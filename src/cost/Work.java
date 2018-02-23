package cost;

import java.util.*;
import common.*;

public class Work extends HashObject {
  public Work() {
    super.put("��������", new Double(1));
    super.put("������M�������", "�������");
    super.put("�����", new VectorObject());
  }

  public String toString() { return get("�������").toString(); }

  public boolean isEmpty() { return get("�������") == null && get("��������") == null; }

  public Object put(String key, Object value) {
    if (key.equals("��������") && value instanceof String) {
      value = new Double(value.toString());
      if (((Number) value).doubleValue() == 0) return remove(key);
    }
    return super.put(key, value);
  }
}