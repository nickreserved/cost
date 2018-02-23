package script;

public class Echo extends Statement {
  Object o;
  public Echo(Object obj) { o = obj; }

  public Object run(RuntimeEnvironment r) {
    Object a = o;
    if (o instanceof Function) {
      a = ((Function) o).run(r);
      if (a == null)
	throw new ExecuteException(null, "� <b>echo</b> ������� �� ������� �� ����������� <b>" + o.toString() +
				   "</b> �� ����� ������� �� <b>null</b>", getLine());
    }
    try {
      r.out.write(a.toString().getBytes());
      return null;
    } catch(Exception e) {
      throw new ExecuteException(null, "�������� ���� ��� ����� ��� stdout: " + e.getMessage(), getLine());
    }
  }

  public String toString() {
    if (o instanceof Function) return "echo " + o.toString() + ";";
    else return "?>" + o.toString() + "<?";
  }

  public Object simplify(RuntimeEnvironment r) {
    Statement a = this;
    if (o instanceof Function) o = ((Function) o).simplify(r);
    if (o == null) {
      a = new Throw("NullPrinting");
      a.setLine(getLine());
    } else if (!(o instanceof Function)) o = o.toString();
    return a;
  }
}