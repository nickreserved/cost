package cost;

import java.util.*;
import common.*;

public class Bill extends DynHashObject {
	public Bill() {
		super.put("���������", 4);
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
			Number ka, pl, tfpa, thold, d = 0d;

			for (int z = 0; z < items.size(); z++)
				d = M.add(d, (Number) items.get(z).getDynamic().get("������������"));
			getDynamic().put("����������", ka = M.round(d, 2));

			HashObject h = new HashObject();
			if (check) setFpa();
			for (int z = 0; z < items.size(); z++) {
				BillItem bi = items.get(z);
				Number fpa = (Number) bi.get("���");
				d = (Number) h.get(fpa.toString());
				Number va = (Number) bi.getDynamic().get("������������");
				if (fpa.doubleValue() != 0) {
					if (d == null) h.put(fpa.toString(), va); else h.put(fpa.toString(), M.add(d, va));
				}
			}
			d = 0d;
			Iterator<String> it = h.keySet().iterator();
			while (it.hasNext()) {
				Number fpa = new Byte(it.next().toString());
				Number f = M.round(M.mul((Number) h.get(fpa.toString()), fpa.doubleValue() / 100), 2);
				h.put(fpa.toString(), f);
				d = M.round(M.add(d, f), 2);
			}
			h.put("������", tfpa = d);
			getDynamic().put("�������������", h);


			Hold hold = (Hold) get("�������������������������");
			h = new HashObject();
			TreeMap<Number, String> tm = new TreeMap<>();
			Number sum = M.round(M.mul(ka, M.div((Number) hold.getDynamic().get("������"), 100)), 2);
			h.put("������", thold = sum);
			Iterator en = hold.keySet().iterator();
			while (en.hasNext()) {
				String k = en.next().toString();
				d = M.mul(ka, M.div((Number) hold.get(k), 100));
				double diff = d.doubleValue();
				sum = M.sub(sum, d = M.round(d, 2));
				h.put(k, d);
				diff = 1000 * (diff - d.doubleValue()) + Math.random() / 100;
				tm.put(new Double(diff), k);
			}
			int z = (int) (100 * M.round(sum, 4).doubleValue());
			if (z > 0) {
				for (; z > 0; z--) {
					Number last = tm.lastKey();
					String k = tm.get(last);
					h.put(k, M.add((Number) h.get(k), 0.01));
					tm.remove(last);
				}
			} else {
				for (z =- z; z > 0; z--) {
					Number first = tm.firstKey();
					String k = tm.get(first);
					h.put(k, M.sub((Number) h.get(k), 0.01));
					tm.remove(first);
				}
			}
			getDynamic().put("����������������������", h);

			String type = (String) ((Provider) get("�����������")).get("�����");
			Number kat = "�������".equals(type) || "�������".equals(type) ? M.add(thold, tfpa) : tfpa;
			getDynamic().put("������������", kat = M.round(M.add(kat, ka), 2));

			getDynamic().put("��������", pl = M.round(M.sub(kat, thold), 2));

			if (check) setFe();
			Number fe = (Number) get("���������");
			Number kak = fe.intValue() == 3 ? ka : M.round(M.sub(ka, thold), 2);
			getDynamic().put("���������������", kak);
			getDynamic().put("��������", fe = M.round(M.mul(kak, fe.doubleValue() / 100), 2));

			getDynamic().put("����������������", M.round(M.sub(pl, fe), 2));
		} catch(NullPointerException | NumberFormatException e) {}
	}

	protected void setFe() {
		byte a = ((Number) get("���������")).byteValue();
		if (a == 0) return;
		String c = (String) get("���������");
		if (!"�������".equals(((Provider) get("�����������")).get("�����"))) super.put("���������", 0);
		else if (((Hold) get("�������������������������")).get("����") != null) { if (a != 3) super.put("���������", 3); }
		else if (c.equals("������ ���������")) { if (a != 8) super.put("���������", 8); }
		else if (c.equals("��������� ������")) { if (a != 4) super.put("���������", 4); }
		else if (c.equals("����� ����� ��������")) { if (a != 1) super.put("���������", 1); }
	}

	protected void setFpa() {
		List items = (List) get("����");
		String a = (String) ((Provider) get("�����������")).get("�����");
		for (int z = 0; z < items.size(); z++) {
			BillItem bi = (BillItem) items.get(z);
			if ("�������".equals(a) || "�����������".equals(a)) bi.put("���", 0);

		}
	}
}