/*자바 프로그래밍 기말과제*/
package finaltest;

/*독립된 클래스들이지만 한 클래스내에 작성하였음*/
//자바 이벤트 관련 라이브러리 불러옴
import javax.swing.*;

import java.awt.*;
import java.awt.event.*;
import java.util.ArrayList;
/*FigureEditor은 마우스로 도형그리기 이벤트를 실행하는 메인클래스 입니다.*/
public class FigureEditor{  
	public static void main(String[] args) {
		new FigureEditorFrame();
	}
}
//FigureEditorFrame 클래스는 메인 컨테이너로, 패널들을 포함, 배치하는 클래스입니다.
class FigureEditorFrame extends JFrame{
	PanelA panelA; //PanelA에서 주된 이벤트가 발생하니 멤버변수로 하여 정보전달 가능하게
	FigureEditorFrame(){
		setTitle("기말 프로젝트");
		setSize(600,300);
		//패널 생성 및 배치 설정
		panelA=new PanelA();
		add(panelA,BorderLayout.CENTER);
		add(new PanelC(panelA),BorderLayout.WEST);//해당 객체를 넘김
		setVisible(true);
	}
}
