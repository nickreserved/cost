package common;

import java.util.*;
import java.text.*;
import javax.swing.*;
import java.util.regex.*;

public class Functions {
  private Functions() {}



  static final public String[] months = { "���", "���", "���", "���", "���", "����", "����", "���",
      "���", "���", "���", "���" };

  static final public String[] days = { "���", "���", "���", "���", "���", "���", "���" };



  static public Object safeObject2String(Object o) { return o == null ? "" : o; }


  // return offset+1 of closing character of this block
  // type of blocks:  []  {}  ()
  // first character of string describe which type of blocks is.
  // default block (if not character of [ { ( ) is ()
  // strings inside block skipped (maybe they have block characters)
  static public int findBlockCloser(String s, int start) {
    return -1;
  }



  final static public int getCurrentLine(String s, String pat, int en) {
    int c = 0;
    for(int z = 0; (z = s.indexOf(pat, z)) != -1 && z < en; z++) c++;
    return c;
  }


  // trying to skip the regex in pos position of string and return a new pos
  final static public int skipRegex(String html, int pos, String regex) {
    int a = Functions.findEndOfRegex(html, pos, regex);
    return a == -1 ? pos : a;
  }

  // return end of a regex which starts here or -1
  final static public int findEndOfRegex(String s, int start, String regex) {
    Matcher m = Pattern.compile(regex).matcher(s);
    return m.find(start) && m.start() == start ? m.end() : -1;
  }

  // return first occurance of regex in string or -1
  final static public int findFirstRegex(String s, int start, String regex) {
    Matcher m = Pattern.compile(regex).matcher(s);
    return m.find(start) ? m.start() : -1;
  }


  // convert a string to uppercase (in Greek capital letters has no tone)
  // if we have e.g. "1�� �����" it returns "1�� �����" and not "1�� ˼���"
  final static public String toUppercase(String s) {
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


  // if string starts with ', return index of closest ', else
  // find where a string close with " and returns offset.
  // it parses \" as character " and not as string closer.
  // it check 'start' character as string starter (char " or ')
  final static public int getStringClosePosition(String s, int start) {
    if (s.charAt(start) == '\'') return s.indexOf("'", start + 1);
    else if (s.charAt(start) != '"') return -1;
    while ((start = s.indexOf('"', ++start)) != -1) {
      int c = start;
      while (c != 0 && s.charAt(--c) == '\\');
      c = (start - c) % 2;
      if (c == 1) break;
    }
    return start;
  }


  // returns the greek enumeration system for numbers 1 to 89
  // not over 89 because 90 is a non printable character
  // maybe fix later
  final static public String letterCounter(int n) {
    if (n < 1 || n > 89) return "";
    String[] m = { "", "�", "�", "�", "�", "�", "��", "�", "�", "�" };
    String[] d = { "", "�", "�", "�", "�", "�", "�", "�", "�" };
    return d[n / 10] + m[n % 10];
  }




  // return fullwritten number d to euros
  final static public String getEuroFullWritten(Number d) throws ParseException {
    String[] s = d.toString().split(".", 2);
    String b = null, a = numToText(s[0]);
    if (s.length == 2) b = numToText(s[1].substring(0, 2));
    if (b != null && !b.equals("�����")) b += " �����"; else b = null;
    if (a.equals("�����")) {
      if (b == null) return "����� ����"; else return b;
    } else {
      return a + " ����" + (b == null ? "" : " ��� " + b);
    }
  }

  // return full written string for a number
  final static public String numToText(String s) throws ParseException {
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
	if (s.substring(1).equals("00") && a == 1) a = 0;
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
				  "<html>������������ �� �������� ����������� ���������:<br>" +
				  Functions.getException(e, null).getMessage(), s,
				  JOptionPane.ERROR_MESSAGE);
  }







  public static String multipleInflections(String a, byte what) {
    String out = "";
    int s, prev = 0;
    Matcher m = Pattern.compile("(\\p{InGreek}{3,}+)").matcher(a);
    while(m.find()) {
      out += a.substring(prev, s = m.start());
      out += getInflection(m.group(), what);
      prev = m.end();
    }
    out += a.substring(prev, a.length());
    return out;
  }





  final public static String getInflection(String onomastikh, byte what) {
    if (onomastikh.endsWith("��") && what == 1) return onomastikh.replace('�', '�');
    else if (onomastikh.endsWith("��") && what == 1) return onomastikh.replace('�', '�');
    else if (what >= 2 && what <= 3 && (
	onomastikh.endsWith("��") || onomastikh.endsWith("��")) ||
	what >= 1 && what <= 3 && (
	onomastikh.endsWith("��") || onomastikh.endsWith("��") ||
	onomastikh.endsWith("��") || onomastikh.endsWith("��") ||
	onomastikh.endsWith("��") || onomastikh.endsWith("��") ||
	onomastikh.endsWith("��") || onomastikh.endsWith("��"))) {
      return onomastikh.replaceAll("�", "");
    } else if (what == 1 && (
	onomastikh.endsWith("�") || onomastikh.endsWith("�") ||
	onomastikh.endsWith("�") || onomastikh.endsWith("�") ||
	onomastikh.endsWith("�") || onomastikh.endsWith("�")))
      return onomastikh + "�";
    return onomastikh;
  }
}