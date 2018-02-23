package cost;

public class OrderId implements FromString, Hashing {
  protected static final String[] hashKeys = { "fakelos", "ypofakelos", "prwtokollo",
      "sxedio", "date", "from" };

  String order;

  public OrderId() {}
  public OrderId(String s) { fromString(s); }

  public String toString() { return (order == null) ? "" : order; }

  // ---------------------------- FromString --------------------------------------------- //

  public void fromString(String s) {
    if (s.matches("�\\.?\\d{3}/\\d+/\\d+/�\\.?\\d+/\\d{2} \\p{InGreek}{3,4} \\d{4}/.+")) order = s;
  }

  // ---------------------------- Hashing --------------------------------------------- //

  public Object hash(String s) throws Exception {
    if (order == null) throw new Exception("��� �������������� � ����� <b>OrderId</b>");
    String[] d = order.split("/", 6);
    for (int z = 0; z < hashKeys.length; z++)
      if (s.equals(hashKeys[z])) return d[z];
    throw new Exception("� ����� <b>Order</b> ��� ����������� �� ����� <b>" + s + "</b>");
  }
}