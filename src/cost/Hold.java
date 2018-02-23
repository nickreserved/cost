package cost;

import common.*;

public class Hold extends DynHashObject {
  public Hold() { getDynamic().put("������", new Double(0)); }
  public String toString() { return getDynamic().get("������").toString(); }
	
  public Object put(String key, Object value) {
    Number d = M.parseString(value.toString());
    d = d == null ? new Integer(0) : M.round(d, 3);
    Number o = (Number) super.put(key, d.doubleValue() == 0 ? null : d);
    Number t = (Number) getDynamic().get("������");
    if (o == null) o = new Integer(0);
    getDynamic().put("������", M.round(M.sub(M.add(t, d), o), 3));
		return o;
  }
}