/*java Shape Paint
 *can draw,move,copy,delete Shape 
 *save paint, bring paint File*/

import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
import java.util.ArrayList;
/*FigureEditor is mainClass to implement.*/
public class FigureEditor{  
	public static void main(String[] args) {
		new FigureEditorFrame();
	}
}
/*FigureEditorFrame is main Container class->include&place panel*/
class FigureEditorFrame extends JFrame{
	PanelA panelA; //PanelA에서 주된 이벤트가 발생하니 멤버변수로 하여 정보전달 가능하게
	FigureEditorFrame(){
		setTitle("Shape Paint");
		setSize(600,300);
		//패널 생성 및 배치 설정
		panelA=new PanelA();
		add(panelA,BorderLayout.CENTER);
		add(new PanelC(panelA),BorderLayout.WEST);//해당 객체를 넘김
		setVisible(true);
	}
}
