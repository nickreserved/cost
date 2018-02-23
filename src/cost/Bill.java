package cost;

import java.util.*;
import common.*;

public class Bill extends DynHashObject {
	public Bill() {
		super.put("���������", (byte) 4);
		super.put("���������", "��������� ������");
		super.put("����", new VectorObject());
	}

	@Override
	public String toString() { return get("���������").toString(); }

	@Override
	public Object put(String key, Object value) {
		Object o = super.put(key, value);
		recalculate();
		return o;
	}

	protected final void recalculate() {
		boolean check = MainFrame.data == null ? false :
				!Boolean.TRUE.equals(((HashObject) MainFrame.data.get("���������")).get("��������������������"));
		try {
			ArrayList<BillItem> items = (ArrayList) get("����");
			Double d = 0.0;
			double ka, pl, tfpa, thold;

			for (BillItem bi : items)
				d = d + (Double) bi.getDynamic().get("������������");
			getDynamic().put("����������", ka = Functions.round(d, 2));

			HashObject h = new HashObject();
			if (check) setFpa();
			for (BillItem bi : items) {
				Byte fpa = ((Number) bi.get("���")).byteValue();
				d = (Double) h.get(fpa.toString());
				double va = (double) bi.getDynamic().get("������������");
				if (fpa != 0) {
					if (d == null) h.put(fpa.toString(), va); else h.put(fpa.toString(), d + va);
				}
			}
			d = 0d;
			Iterator<String> it = h.keySet().iterator();
			while (it.hasNext()) {
				Byte fpa = new Byte(it.next().toString());
				double f = Functions.round((Double) h.get(fpa.toString()) * fpa / 100.0, 2);
				h.put(fpa.toString(), f);
				d = Functions.round(d + f, 2);
			}
			h.put("������", tfpa = d);
			getDynamic().put("�������������", h);

			Hold hold = (Hold) get("�������������������������");
			h = new HashObject();
			TreeMap<Double, String> tm = new TreeMap<>();
			double sum = Functions.round(ka * (double) hold.getDynamic().get("������") / 100, 2);
			h.put("������", thold = sum);
			Iterator en = hold.keySet().iterator();
			while (en.hasNext()) {
				String k = en.next().toString();
				double diff = d = ka * (double) hold.get(k) / 100;
				sum = sum - (d = Functions.round(d, 2));
				h.put(k, d);
				diff = 1000 * (diff - d) + Math.random() / 100;
				tm.put(diff, k);
			}
			int z = (int) (100 * Functions.round(sum, 4));
			if (z > 0) {
				for (; z > 0; z--) {
					Double last = tm.lastKey();
					String k = tm.get(last);
					h.put(k, (double) h.get(k) + 0.01);
					tm.remove(last);
				}
			} else {
				for (z =- z; z > 0; z--) {
					Number first = tm.firstKey();
					String k = tm.get(first);
					h.put(k, (double) h.get(k) - 0.01);
					tm.remove(first);
				}
			}
			getDynamic().put("����������������������", h);

			String type = (String) ((Provider) get("�����������")).get("�����");
			double kat = "�������".equals(type) || "�������".equals(type) ? thold + tfpa : tfpa;
			getDynamic().put("������������", kat = Functions.round(kat + ka, 2));

			getDynamic().put("��������", pl = Functions.round(kat - thold, 2));

			if (check) setFe();
			byte fe = ((Number) get("���������")).byteValue();
			double fee, kak = fe == 3 ? ka : Functions.round(ka - thold, 2);
			getDynamic().put("���������������", kak);
			getDynamic().put("��������", fee = Functions.round(kak * fe / 100.0, 2));

			getDynamic().put("����������������", Functions.round(pl - fee, 2));
		} catch(NullPointerException | NumberFormatException e) {}
	}

	protected void setFe() {
		byte a = ((Number) get("���������")).byteValue();
		if (a == 0) return;
		String c = (String) get("���������");
		if (!"�������".equals(((Provider) get("�����������")).get("�����"))) super.put("���������", (byte) 0);
		else if (c.equals("������ ���������")) {
			Cost co = null;
			if (MainFrame.costs != null) co = (Cost) MainFrame.costs.get();
			if (co != null && CostData.cosT[0].equals((String) co.get("������������"))) { if (a != 3) super.put("���������", (byte) 3); }
			else if (a != 8) super.put("���������", (byte) 8);
		} else if (c.equals("��������� ������")) { if (a != 4) super.put("���������", (byte) 4); }
		else if (c.equals("����� ����� ��������")) { if (a != 1) super.put("���������", (byte) 1); }
	}

	protected void setFpa() {
		List<BillItem> items = (List) get("����");
		String a = (String) ((Provider) get("�����������")).get("�����");
		for (BillItem bi : items)
			if ("�������".equals(a) || "�����������".equals(a)) bi.put("���", (byte) 0);
	}
}