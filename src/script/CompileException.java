package script;

public class CompileException extends RuntimeException {
  private int a;
  public CompileException(int line, String why) {
    super(why);
    a = line;
  }
  public int getLine() { return a; }
  public String toString() {
    String s = "������ �������������";
    if (a != -1) s += " ��� ������ " + a;
    if (getMessage() != null) s += "<br>" + getMessage();
    return s;
  }
}