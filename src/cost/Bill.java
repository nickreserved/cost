package cost;

import java.util.*;
import common.*;

public class Bill extends HashObject {
  public Bill() {
    put("���������", new Byte((byte) 4));
    put("�����", "���������");
    put("���������", "��������� ������");
    put("����", new VectorObject());
  }

  public boolean isEmpty() { return super.get("���������") == null; }
  public String toString() { return super.get("���������").toString(); }
  public boolean equals(Object o) { return o instanceof Bill && toString().equals(o.toString()); }

  public Object put(Object key, Object value) {
    if (key.equals("���������") && !isValidBill(value.toString()) && !value.toString().equals(""))
      return null;
    return super.put(key, value);
  }

  public Object get(Object key) {
    Object o = super.get(key);
    if (o != null) return o;

    Vector items = (Vector) get("����");
    Number d = new Double(0);

    if (key.equals("����������")) {
      for (int z = 0; z < items.size(); z++)
	d = M.add(d, (Number) ((BillItem) items.get(z)).get("������������"));
      o = M.round(d, 2);
    } else if (key.equals("�������������")) {
      Hashtable h = new Hashtable();
      setFpa();
      for (int z = 0; z < items.size(); z++) {
	BillItem bi = (BillItem) items.get(z);
	Number fpa = (Number) bi.get("���");
	d = (Number) h.get(fpa);
	Number va = (Number) bi.get("������������");
	if (fpa.doubleValue() != 0) {
	  if (d == null) h.put(fpa, va); else h.put(fpa, M.add(d, va));
	}
      }
      d = new Double(0);
      Enumeration en = h.keys();
      while (en.hasMoreElements()) {
	Number fpa = (Number) en.nextElement();
	Number f = (Number) h.get(fpa);
	h.put(fpa, f = M.round(M.mul(f, fpa.doubleValue() / 100), 2));
	d = M.add(d, f);
      }
      h.put("������", M.round(d, 2));
      o = h;

    } else if (key.equals("����������������������")) {
      Hashtable h = new Hashtable(), hold = (Hashtable) super.get("�������������������������");
      TreeMap tm = new TreeMap();
      Number ka = (Number) get("����������");
      Number sum = M.round(M.mul(ka, M.div((Number) hold.get("������"), 100)), 2);
      h.put("������", sum);
      Enumeration en = hold.keys();
      while (en.hasMoreElements()) {
	Object k = en.nextElement();
	if (!k.equals("$������")) {
	  d = M.mul(ka, M.div((Number) hold.get(k), 100));
	  double diff = d.doubleValue();
	  sum = M.sub(sum, d = M.round(d, 2));
	  h.put(k, d);
	  diff = 1000 * (diff - d.doubleValue()) + Math.random() / 100;
	  tm.put(new Double(diff), k);
	}
      }
      int z = (int) (100 * M.round(sum, 4).doubleValue());
      if (z > 0) {
	for (; z > 0; z--) {
	  Object last = tm.lastKey();
          Object k = tm.get(last);
          h.put(k, M.round(M.add((Number) h.get(k), 0.01), 2));
	  tm.remove(last);
	}
      } else {
	for (z =- z; z > 0; z--) {
	  Object first = tm.firstKey();
          Object k = tm.get(first);
          h.put(k, M.round(M.sub((Number) h.get(k), 0.01), 2));
	  tm.remove(first);
	}
      }
      o = h;

    } else if (key.equals("������������"))
      o = M.round(M.add((Number) ((Hashtable) get("��/���".equals(super.get("�����")) ?
                                                  "����������������������" : "�������������")).get("������"),
                        (Number) get("����������")), 2);
    else if (key.equals("��������"))
      o = M.round(M.sub((Number) get("������������"), (Number)
                        ((Hashtable) get("����������������������")).get("������")), 2);

    else if (key.equals("��������")) {
      setFe();
      o = M.round(M.mul((Number) get("������������������������"), ((Number)
          get("���������")).doubleValue() / 100), 2);

    } else if (key.equals("������������������������"))
      o = M.round(M.sub((Number) get("����������"), (Number)
                        ((Hashtable) get("����������������������")).get("������")), 2);

    else if (key.equals("����������������"))
      o = M.round(M.sub((Number) get("��������"), (Number) get("��������")), 2);

    if (o != null) super.put("$" + key, o);
    return o;
  }

  protected void setFe() {
    if (!super.get("�����").equals("���������")) super.put("���������", new Byte((byte) 0));
    else if (((Number) super.get("���������")).doubleValue() != 0)
      if (super.get("���������").equals("������ ���������")) super.put("���������", new Byte((byte) 8));
      else if (super.get("���������").equals("��������� ������")) super.put("���������", new Byte((byte) 4));
      else super.put("���������", new Byte((byte) 1));
  }

  protected void setFpa() {
    List items = (List) get("����");
    for (int z = 0; z < items.size(); z++) {
      BillItem bi = (BillItem) items.get(z);
      if (super.get("�����").equals("��/���"))
	bi.put("���", new Byte((byte) 0));
      else if (((Number) bi.get("���")).doubleValue() == 0)
	bi.put("���", new Byte((byte) 19));
    }
  }

  protected static boolean isValidBill(String bill) {
    return bill.matches("\\d+/\\d+-\\d+-\\d+");
  }
}