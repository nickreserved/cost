package cost;

import java.util.*;
import common.*;

public class Provider extends HashObject {
  public String toString() { return get("��������").toString(); }
  public boolean equals(Object o) { return o instanceof Provider && toString().equals(o.toString()); }
}