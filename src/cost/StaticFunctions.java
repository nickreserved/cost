package cost;

import java.util.*;
import java.text.*;
import javax.swing.*;

public class StaticFunctions {
  private StaticFunctions() {}



  static final public String[] months = { "���", "���", "���", "���", "���", "����", "����", "���",
      "���", "���", "���", "���" };

  static final public String[] days = { "���", "���", "���", "���", "���", "���", "���" };



  static public Vector propertiesarray2vector (Object[][] s) {
    Vector v = new Vector();
    for (int z = 0; z < s.length; z++) v.add(s[z][0]);
    return v;
  }





  static public String letterCounter(int n) {
    if (n < 1 || n > 89) return "";
    String[] m = { "", "�", "�", "�", "�", "�", "��", "�", "�", "�" };
    String[] d = { "", "�", "�", "�", "�", "�", "�", "�", "�" };
    return d[n / 10] + m[n % 10];
  }





  static public String getEuroFullWritten(Digit d) throws ParseException {
    String[] s = d.toString().split(",", 2);
    String b = null, a = numToText(s[0]);
    if (s.length == 2) b = numToText(s[1].substring(0, 2));
    if (b != null && !b.equals("�����")) b += " �����"; else b = null;
    if (a.equals("�����")) {
      if (b == null) return "����� ����"; else return b;
    } else {
      return a + " ����" + (b == null ? "" : " ��� " + b);
    }
  }


  static public String numToText(String s) throws ParseException {
    String[][] other = { { "�����", "��������" }, { "�����������", "�����������" } };
    String[] other_1 = { "���", "����", "��������", "��������", "������", "�������", "�������" };

    String o = "", t;
    if (s.length() == 0) return "�����";
    int a, c = 0;

    while ((a = s.length()) != 0) {
      if (a > 2) {
        t = s.substring(a - 3);
        s = s.substring(0, a - 3);
      } else {
        t = s;
        s = "";
      }
      t = numToText100(t, c == 1) + " ";
      if (c == 0);
      else if (c > 2) {
        t += other_1[c - 3] + (c < 5 ? "" : " ");
        c = 2;
      }
      if (c > 0 && c <= 2) {
        int j = 1;
        if (t.startsWith("���")) {
            if (c == 1) t = other[c - 1][0]; else t += other[c - 1][0];
        } else if (t.trim().length() != 0)
          t += other[c - 1][1];
      }
      o = t + " " + o;
      c++;
    }
    o = o.replaceAll("\\s+", " ").trim();
    return o.length() == 0 ? "�����" : o;
  }


  static private String numToText100(String s, boolean female) throws ParseException {
    String[] ekatodades = { "�����", "������", "��������", "���������", "����������", "����������", "��������", "���������", "���������", "����������" };
    String[] dekades = { "������", "�������", "�������", "�������", "������", "���������", "�������", "���������" };
    String[] monades = { "���", "���", "����", "�������", "�����", "���", "����", "����", "�����", "����", "������", "������", "��������", "�����������", "���������", "�������", "��������", "��������", "���������" };
    String[] monades_2 = { "���", "���", "�����", "���������", "�����", "���", "����", "����", "�����", "����", "������", "������", "���������", "�������������", "���������", "�������", "��������", "��������", "���������" };

    String o = "";
    int a = 0;
    if (s.length() > 3) throw new ParseException(null, 0);
    if (s.length() == 3) {
      a = s.charAt(0) - "0".charAt(0);
      if (a > 0 && a < 10) {
        if (s.substring(1).equals("00")) a = 0;
        o = ekatodades[a];
      }
      s = s.substring(1);
    }
    if (s.length() == 2) {
      a = s.charAt(0) - "0".charAt(0);
      if (a > 1 && a < 10) o += " " + dekades[a - 2];
      s = s.substring(1);
    }
    a = s.charAt(0) - "0".charAt(0) + (a == 1 ? 10 : 0);
    if (a != 0) {
      if (!female) o += " " + monades[a - 1];
      else o += " " + monades_2[a - 1];
    }
    return o.trim();
  }





  static public String toUppercase(String s) {
    String t = "";
    boolean num = false;
    for (int z = 0; z < s.length(); z++) {
      char c = s.charAt(z);
      if (" \r\n\t".indexOf(c) != -1) num = false;
      else if (num);
      else if ("0123456789".indexOf(c) != -1) num = true;
      else
        c = ("" + c).toUpperCase().replaceAll("�", "�").replaceAll("�", "�")
            .replaceAll("�", "�").replaceAll("�", "�").replaceAll("�", "�")
            .replaceAll("�", "�").replaceAll("�", "�").charAt(0);
      t += c;
    }
    return t;
  }






  static public int findInArray(Object[] a, Object b) {
    if (b == null) return -1;
    for (int z = 0; z < a.length; z++)
      if (b.equals(a[z])) return z;
    return -1;
  }








  static public Exception getException(Exception e, String s) {
    String a = e == null ? null : e.getMessage();
    if (a == null || a.length() < 5) a = null;
    String b = e == null ? null : e.getClass().getName();
    if (b != null && b.equals("java.lang.Exception")) b = null;
    if ((a != null || b != null) && s != null) s = "<br>" + s;
    if (s == null) s = "";
    if (a != null) s = a + s;
    if (a != null && b != null) s = ": " + s;
    if (b != null) s = "<b>" + b + "</b>" + s;
    return new Exception(s);
  }








  public static void showExceptionMessage(Exception e, String s) {
    JOptionPane.showMessageDialog(null,
                                  "<html>������������ �� �������� ����������� ���������:<br><b>" +
                                  StaticFunctions.getException(e, null).getMessage(), s,
                                  JOptionPane.ERROR_MESSAGE);
  }
}