package cost;

import common.*;

public class ContentItem extends HashObject {
	public ContentItem() { super.put("������", (byte) 1); }
	public String toString() { return (String) get("��������������"); }
}