package cost;

import java.util.*;
import common.*;

public class Hold extends HashObject {
  public Hold() { super.put("$������", new Double(0)); }
  public String toString() { return get("������").toString(); }
  
  public Object put(String key, Object value) {
    Number d = M.parseString(value.toString());
    d = d == null ? new Integer(0) : M.round(d, 3);
    Number o = (Number) super.put(key, d.doubleValue() == 0 ? null : d);
    Number t = (Number) get("������");
    if (t == null) t = new Integer(0);
    if (o == null) o = new Integer(0);
    super.put("$������", M.round(M.sub(M.add(t, d), o), 3));
    return o;
  }
}