package finaltest;

import javax.swing.JPanel;

class PanelC extends JPanel{
	PanelC(PanelA panelA){
		add(new PanelB(panelA));
	}
}
