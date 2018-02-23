package cost;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;

public class CostWizardDialog extends JDialog implements ActionListener, DocumentListener {

	public CostWizardDialog(Window w) {
    super(w, "������ ����������");
		
		setLayout(new BorderLayout());
		((JPanel) getContentPane()).setBorder(BorderFactory.createEmptyBorder(5,5,5,5));
		Box bv = Box.createVerticalBox();
		
		Box bh = Box.createHorizontalBox();
		bh.add(new JLabel("���� �������������� ��� �������:"));
		bh.add(Box.createHorizontalStrut(5));
		bh.add(cbMoney = new JComboBox(new String[] { "����� �����", "�������",
				"������ ��������� ���������� (��������� ���������)" }));
		bv.add(bh); bv.add(Box.createVerticalStrut(5));

		bh = Box.createHorizontalBox();
		bh.add(new JLabel("����� �������:"));
		bh.add(Box.createHorizontalStrut(5));
		bh.add(cbCost = new JComboBox(new String[] { "���������, ��������, ��������� ����� ��", "������" }));
		bv.add(bh); bv.add(Box.createVerticalStrut(5));

		bh = Box.createHorizontalBox();
		bh.add(new JLabel("����� ����������:"));
		bh.add(Box.createHorizontalStrut(5));
		bh.add(cbProvider = new JComboBox(new String[] { "������� (��������, �����������, ���������, �������)",
				"������� (������, ��������, �.�.�.)", "������� (���, ���, �.�.�.)", "����������� (��������� �������������)" }));
		bv.add(bh); bv.add(Box.createVerticalStrut(5));

		bh = Box.createHorizontalBox();
		bh.add(new JLabel("����� ����������:"));
		bh.add(Box.createHorizontalStrut(5));
		bh.add(cbBill = new JComboBox(new String[] { "��������� ������", "������ ���������", "����� ����� ��������" }));
		bv.add(bh); bv.add(Box.createVerticalStrut(5));
		
		bh = Box.createHorizontalBox();
		bh.add(new JLabel("������ ���� ����������:"));
		bh.add(Box.createHorizontalStrut(5));
		bh.add(tfValue = new JTextField());
		bv.add(bh); bv.add(Box.createVerticalStrut(5));

		bh = Box.createHorizontalBox();
		bh.add(new JLabel("<html>" + lblBills));
		bh.add(Box.createHorizontalStrut(5));
		bh.add(tfValueProvider = new JTextField());
		bv.add(bh); bv.add(Box.createVerticalStrut(5));

		getContentPane().add(bv, BorderLayout.PAGE_START);

		tpInfo = new JTextPane();
	  tpInfo.setEditable(false);
    tpInfo.setContentType("text/html");
		getContentPane().add(new JScrollPane(tpInfo), BorderLayout.CENTER);

		setSize(600, 450);
		setDefaultCloseOperation(javax.swing.WindowConstants.HIDE_ON_CLOSE);
		
		cbMoney.addActionListener(this);
		cbProvider.addActionListener(this);
		cbCost.addActionListener(this);
		cbBill.addActionListener(this);
		tfValue.getDocument().addDocumentListener(this);
		tfValueProvider.getDocument().addDocumentListener(this);
		
		calc();
	}

	private final String lblBills = "������ ���� <b>����</b> ��� ���������� ��� <b>�����</b> ����������:";
  private final JComboBox cbMoney;
  private final JComboBox cbProvider;
  private final JComboBox cbCost;
  private final JComboBox cbBill;
  private final JTextField tfValue;
  private final JTextField tfValueProvider;
  private final JTextPane tpInfo;

	@Override	public void actionPerformed(ActionEvent e) { calc(); }
	@Override public void insertUpdate(DocumentEvent e) { calc(); }
	@Override public void removeUpdate(DocumentEvent e) { calc(); }
	@Override	public void changedUpdate(DocumentEvent e) { calc(); }
	
	private void calc() {
		try {
			int[] cb = new int[4];
			cb[0] = cbMoney.getSelectedIndex();
			cb[1] = cbCost.getSelectedIndex();
			cb[2] = cbProvider.getSelectedIndex();
			cb[3] = cbBill.getSelectedIndex();
			
			double value = common.M.round(Double.parseDouble(tfValue.getText()), 2);
			double valueprovider = 0;
			boolean fpa = true;
			double hold = 0;
			boolean agreement = false;
			int fe = 0;			
			String text = "<html><style>ul {margin-top: -15px; margin-bottom: 0}</style>";
			
			try {
				valueprovider = common.M.round(Double.parseDouble(tfValueProvider.getText()), 2);
			} catch (NumberFormatException e) {}
			if (valueprovider < value) valueprovider = value;
			text += "<b>������ ����:</b> " + value + " �<br>" + lblBills + " " + valueprovider + " �";
			
			if (cb[2] == 1 /*�������*/ || cb[2] == 3 /*�����������*/) fpa = false;
			text += "<br><b>���:</b> " + (fpa ? "����������� ��� �� �������� � �����������" : "0%");
			
			switch(cb[0]) {
				case 0 /*����� �����*/:
				case 1 /*�������*/:
					switch(cb[2]) {
						case 0 /*�������*/:
							if (cb[1] == 0 /*��������� �����*/ && cb[3] == 1 /*������ ���������*/)
								if (valueprovider < 2500) hold = 5.12; else { hold = 5.2236; agreement = true; }
							else
								if (valueprovider < 2500) hold = 4.096; else { hold = 4.1996; agreement = true; }
							break;
						case 1 /*�������*/:
							cbCost.setSelectedIndex(1);	// ������ �������
							if (cb[3] == 1 /*������ ���������*/) cbBill.setSelectedIndex(0); //��������� ������
							hold = 4;
							break;
						case 2 /*�������*/:
							cbCost.setSelectedIndex(1);	// ������ �������
							if (valueprovider < 2500) hold = 4.096; else { hold = 4.1996; agreement = true; }
							break;
						default /*�����������*/:
							cbCost.setSelectedIndex(1);	// ������ �������
							cbBill.setSelectedIndex(1); // ������ ���������
					}
					if (cb[0] == 0 && hold != 0) hold = common.M.round(hold + 10, 4);
					break;
				case 3 /*��.��.*/:
					cbCost.setSelectedIndex(1);
					cbProvider.setSelectedIndex(0);
					if (cb[3] == 1) cbBill.setSelectedIndex(0);
					hold = 4.6092;
			}
			text += "<br><b>���������:</b> " + hold + "% ��� ������� ����� (" +
					Math.round(value * hold) / 100 + " �), ��� �������� " +
					(cb[2] != 0 /*�������*/ ? "����" : "��� ����������") +
					"<br><b>������������:</b> ������ ����" + (fpa ? " + ���" : "") +
					(cb[2] != 0 /*�������*/ ? " + ���������" : "");			
			
			{
			double valueforfe = value;
			if (cb[2] == 0 /*�������*/ && valueprovider > 150 /*���������� ��� ����������*/) {
				final int[] a = { 4, 8, 1 };
				fe = a[cb[3]];	// ����� ����������
				if (cb[3] == 1 /*������ ���������*/ && cb[1] == 0 /*��������� �����*/) fe = 3;
				else valueforfe = value - Math.round(hold * value) / 100;
			}
			text += "<br><b>��:</b> " + fe + "% ��� ������� �����" +
					(fe == 3 ? "" : " ����� ���������") + " (" + Math.round(valueforfe * fe) / 100 + " �)<br>";
			}
	
			if (cb[1] == 0 /*��������� �����*/ && cb[3] == 1 /*������ ���������*/) {
				double a = common.M.round(0.005 * value, 2);
				text += "<br>� ��������� ������ �� ��� �������� ����������� ��������� ���:<ul><li>0.5% <b>���</b> ��� ������� ����� (" +
						a + " �)<li>0.5% <b>������</b> ��� ������� ����� (" + a + " �)<li>0.5% <b>�����</b> ��� ������� ����� (" + a +
						" �)</ul>��������� ������������ ��� <b>������</b> ����� ������������ �� ��� ��������� ����������� ��������� ��� <b>������</b>:" +
						"<ul><li><b>��������� �������:</b><ul><li>�� �� ���� ����� <b>������ ���������</b>: 2% ��� 10% ��� ������� ����� (" +
						common.M.round(0.002 * value, 2) + " �)<li>�� �� ���� ����� <b>���������� ����������</b>: 2% ��� 25% ��� ������� ����� (" +
						a + " �)</ul><li><b>���� ������ (�2166/93):</b> 0.6% ��� ������� ����� (" +
						common.M.round(0.006 * value, 2) + " �)</ul>";
			}
			
			if (cb[2] == 0 /*�������*/) {
				if (valueprovider > 1220) text += "<br>�� �� ������������ ����� ���� ��� 1500�, ���������� ���������� ����������� ��� ���������� ��� �������� ��� �� �������.";
				if (valueprovider > 2440) text += "<br>�� �� ������������ ����� ���� ��� 3000�, ���������� ����������� ����������� ��� ����������.";
			}
			if (valueprovider > 60000) { text += "<br>���������� �������� �����������."; agreement = true; }
			else if (valueprovider > 15000 || cb[1] == 0 /*��������� �����*/)
				{ text += "<br>���������� ��������� �����������."; agreement = true; }
			if (agreement) text += "<br>���������� ������ �������� �� ��� ����������.";
			
			tpInfo.setText(text);
		} catch(NumberFormatException e) {
			tpInfo.setText("����������� ����� �� �������� ����� ��� �� ������ ����������� ��� �� ��������� ���� ��� �� ������.");
		}
	}
}
