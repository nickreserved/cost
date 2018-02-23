package script.function;

import script.*;
import java.util.*;


public class Mod extends Function {
  public void setVector(List l) {
    if (l.size() != 2) throw new CompileException(getLine(), "function <b>Mod</b> must take 2 parameters");
    v = l;
  }
  public Object run(RuntimeEnvironment r) {
    Object a = v.get(0), b = v.get(1);
    if (a instanceof Function) a = ((Function) a).run(r);
    if (b instanceof Function) b = ((Function) b).run(r);
    if (a instanceof Number && b instanceof Number) {
      if (b.equals(new Integer(0))) throw new ExecuteException("ZeroDivision", "Division by zero", getLine());
      return common.M.mod((Number) a, (Number) b);
    }
    throw new ExecuteException("CastingError", "<b>Mod</b> has a non-number parameter", getLine());
  }

  public Object simplify(RuntimeEnvironment r) {
    Object a = v.get(0), b = v.get(1);
    if (a instanceof Function) a = ((Function) a).simplify(r);
    if (b instanceof Function) b = ((Function) b).simplify(r);
    if (b instanceof Throw) return b;
    else if (b.equals(new Integer(0))) {
      Throw o = new Throw("ZeroDivision", "Division by zero");
      o.setLine(getLine());
      return o;
    } else if (b instanceof Number || b instanceof Function) v.set(1, b);
    else throw new CompileException(getLine(), "<b>Mod</b> has a non-number parameter (<b>" + b + "</b>)");
    if (a instanceof Throw) return a;
    else if (a instanceof Number || a instanceof Function) v.set(0, a);
    else throw new CompileException(getLine(), "<b>Mod</b> has a non-number parameter (<b>" + a + "</b>)");
    if (a instanceof Number && b instanceof Number) return common.M.mod((Number) a, (Number) b);
    return this;
  }

  public String toString() { return "(" + v.get(0) + " % " + v.get(1) + ")"; }
}