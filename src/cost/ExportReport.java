package cost;

import javax.swing.*;
import java.util.*;
import common.*;

public class ExportReport {
	static private JFileChooser fc = new JFileChooser();
	
	private ExportReport() {}
	
	static public void exportReport(String file) { exportReport(file, null); }
	static public void exportReport(String file, Map<String, String> env) {
		PhpScriptRunner php = new PhpScriptRunner(MainFrame.rootPath + "php/", file, null);
		if (env != null) {
			Map<String, String> e = php.getEnvironment();
			e.putAll(env);
		}
		try {
			int a = php.exec(MainFrame.costs.get(MainFrame.currentCost).serialize(), php, php, false);
			String err = php.getStderr();
			if (a != 0) err += "�� php script ��������� �� ������ ������: (" + a + ")";
			if (err != null && !err.equals("")) throw new Exception(err);
file = "c:/e.rtf";/*
			fc.setFileFilter(new ExtensionFileFilter("rtf", "������ �������� (RTF)"));
			int returnVal = fc.showSaveDialog(MainFrame.ths);
			if(returnVal != JFileChooser.APPROVE_OPTION) return;
			file = fc.getSelectedFile().getPath();
			if (!file.endsWith(".rtf")) file += ".rtf";
*/
			LoadSaveFile.saveStringFile(file, php.getStdout() + "}");
		} catch (Exception e) {
			showError(e.getMessage());
		}
	}
	
	static private void showError(String err) {
		JDialog dlg = new JDialog(MainFrame.ths, "�������� ��������� ��������� ��� PHP Script", true);
		JList list = new JList(err.split("\n"));
		JScrollPane scroll = new JScrollPane(list, JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED,
				JScrollPane.HORIZONTAL_SCROLLBAR_AS_NEEDED);
		dlg.add(scroll);
		dlg.pack();
		dlg.setLocation((int) (MainFrame.screenSize.getWidth() - dlg.getWidth()) / 2,
				(int) (MainFrame.screenSize.getHeight() - dlg.getHeight()) / 2);
		dlg.setVisible(true);
	}
}