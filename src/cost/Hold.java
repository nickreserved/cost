package cost;

import common.*;

public class Hold extends DynHashObject {
  public Hold() { getDynamic().put("������", 0); }
  public String toString() { return getDynamic().get("������").toString(); }
	
  public Object put(String key, Object value) {
    Number d = M.parseString(value.toString());
    d = d == null ? 0 : M.round(d, 3);
    Number o = (Number) super.put(key, d.doubleValue() == 0 ? null : d);
    Number t = (Number) getDynamic().get("������");
    if (o == null) o = 0;
    getDynamic().put("������", M.round(M.sub(M.add(t, d), o), 3));
		return o;
  }
}