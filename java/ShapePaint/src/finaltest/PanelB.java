package finaltest;

import java.awt.*;
import java.awt.event.*;
import java.io.*;
import java.util.ArrayList;

import javax.swing.JButton;
import javax.swing.JPanel;

//PanelB는 버튼 이벤트를 처리하는 클래스입니다(저장과 불러오기)
class PanelB extends JPanel{
	PanelA panelA;//멤버변수로 PanelA 클래스를 선언
	PanelB(PanelA panelA){//프레임 객체의 멤버 정보 전달받음
		this.panelA=panelA;
		setLayout(new GridLayout(7,1,5,5));
		setBackground(Color.BLUE);
		JButton btn1=new JButton("사각");
		JButton btn2=new JButton("직선");
		JButton btn3=new JButton("타원");
		JButton btn4=new JButton("복사");
		JButton btn5=new JButton("삭제");
		JButton btn6=new JButton("저장");
		JButton btn7=new JButton("불러오기");
		//각 버튼에 이벤트 리스너 더함
		BtnActionListener btnclick=new BtnActionListener();
		btn1.addActionListener(btnclick);
		btn2.addActionListener(btnclick);
		btn3.addActionListener(btnclick);
		btn4.addActionListener(btnclick);
		btn5.addActionListener(btnclick);
		btn6.addActionListener(btnclick);
		btn7.addActionListener(btnclick);
		add(btn1);
		add(btn2);
		add(btn3);
		add(btn4);
		add(btn5);
		add(btn6);
		add(btn7);
	}
	//내부 클래스 이벤트 리스너-액션 이벤트
	private class BtnActionListener implements ActionListener{
		public void actionPerformed(ActionEvent e) {
			JButton btn=(JButton)e.getSource();
			panelA.selectBtn=btn.getText();//이벤트 발생 버튼의 텍스트로 변경 
			if(btn.getText()=="저장") {
				saveObjectToFile(panelA.shapes,"output.txt");
			}else if(btn.getText()=="불러오기") {
				panelA.shapes=loadObjectFromFile("output.txt");
				panelA.repaint(); //불러온 객체배열로 그려짐
			}
		}
		//output.txt에 shapes 내용 저장:객체 스트림
		public static void saveObjectToFile(ArrayList<Shape>shapes,String fileName) {
			try {
				ObjectOutputStream out=new ObjectOutputStream(new FileOutputStream(fileName));
				out.writeObject(shapes);
			} catch (FileNotFoundException e) {
				e.printStackTrace();
			} catch (IOException e) {
				
				e.printStackTrace();
			}
		}
		//output.txt에 저장된 내용 가져오는 메소드:객체 스트림
		public static ArrayList<Shape>loadObjectFromFile(String fileName){
			ArrayList<Shape> result=null;
			ObjectInputStream in;
			try {
				in = new ObjectInputStream(new FileInputStream(fileName));
				result=(ArrayList<Shape>)in.readObject();
				in.close();
			} catch (FileNotFoundException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			} catch (ClassNotFoundException e) {
				e.printStackTrace();
			}		
			return result;//도형 배열 리턴
		}
	}	
}