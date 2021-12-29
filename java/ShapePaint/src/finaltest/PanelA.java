package finaltest;
//라이브러리 호출
import java.awt.*;
import java.awt.event.*;
import java.util.ArrayList;
import javax.swing.JPanel;

/*PanelA는 도형 그림이 그려지는 캔버스 역할을 하는 클래스로 마우스 이벤트들과 그래픽 메소드가 정의된 클래스입니다.*/
class PanelA extends JPanel{
	/*멤버 변수*/
	ArrayList<Shape> shapes=new ArrayList<Shape>(); //그림 도형 객체를 저장하는 객체 배열
	Point start=null,end=null; //시작과 종료 좌표에 대한 객체 변수	
	ControlPoint cp; //컨트롤 포인트 객체
	Shape select; //선택된 도형 정보가 담긴 Shape
	boolean isFocusS=false,isFocusCP=false;
	String selectBtn; //눌려진 버튼의 정보 저장할 변수
	int btwX,btwY,selectIndex; //간격, 선택인덱스에 대한 변수
	int x,y,width,height,x2,y2; //도형 생성에 대한 변수
	/*생성자*/
	PanelA(){
		setBackground(Color.YELLOW);
		//마우스 이벤트 리스너 설정
		MPListener mplistener=new MPListener();
		addMouseListener(mplistener);
		addMouseMotionListener(mplistener);
		cp=new ControlPoint(1,1,1,1);
	}
	//내부 클래스 이벤트 리스너-마우스 이벤트///
	private class MPListener extends MouseAdapter{
		public void mousePressed(MouseEvent e) { //도형 선택&&해제
			start=e.getPoint(); 
			end=e.getPoint();  
			System.out.printf("%d : %d\n",start.x,start.y);
			/* 도형, 컨트롤 포인트 선택 및 해제: 마우스 이벤트 */
			if(isShapeOrCpSelect(shapes,cp)) {
				repaint(); 
			}
			/* 도형 이동: 마우스 이벤트 */
			switch(selectBtn) { //무빙-위치조절을 위한 스위치 문
				case "사각":
				case "직선":
				case "타원":
					if(isFocusS==true) { //누른곳이랑 선택도형 시작점이 다르니까
						btwX=start.x-select.x; //무빙-시작점과 간격 전송
				        btwY=start.y-select.y;
					}
					break;
				}
		}
		/* 도형 이동, 크기 조절: 마우스 이벤트 */
		public void mouseDragged(MouseEvent e) { //드래그 할 때
			end=e.getPoint();
			repaint();
		}
		/* 도형 복사, 도형 삭제: 마우스 이벤트 */
		public void mouseClicked(MouseEvent e) { //복사와 삭제
			switch(selectBtn) {
				case "복사": //c.copy해서 클래스 반환? return Shape
					ShapeCopy(select,selectIndex,shapes); //도형 복사
					repaint();
					break;
				case "삭제":  //다른 화면을 클릭해도 전에 선택된게 지워짐
					shapes.remove(selectIndex);
					cp.setShow(false); //삭제 된 후에 cp 숨김
					select=null;
					repaint();
					break;
				}
		}
		/* 도형 이동, 크기 조절, 생성: 마우스 이벤트 */
		public void mouseReleased(MouseEvent e) { //마우스를 뗄 때>>드래그했던 도형을 갱신함
			end=e.getPoint();
			if(isFocusCP) { //cp가 선택됬을때
				if(cp.isCp1()) {//좌측 상단 컨트롤 포인트
					SizeChangeWCp1(select,selectIndex,shapes);
				}else{ // cp.isCp2()  우측 하단 컨트롤 포인트
					SizeChangeWCp2(select,selectIndex,shapes);
				}
				return;
			}else if(isFocusS==false) { //도형 생성
				calculateMakeV(start,end);
		        switch(selectBtn) { //선택된 버튼 값에 맞게 객체 생성 및 저장
		        case "사각":
		        	Shape rect=new Rectangle(x,y,width,height);
					shapes.add(rect); //shape객체 배열에 저장>>업 캐스팅
		        	break;
		        case "직선": //다른 도형과 다르게 너비높이가 아니라 시작과 끝점
		        	Shape line=new Line(start.x,start.y,end.x,end.y); //start.x,start.y,end.x,end.y
		        	shapes.add(line);//shape객체 배열에 저장>>업 캐스팅
		        	break;
		        case "타원":
		        	Shape oval=new Oval(x,y,width,height);
		        	shapes.add(oval);//shape객체 배열에 저장>>업 캐스팅
		        	break;
		        }
			}else {  //isFocusS==True 도형 이동
				switch(selectBtn) { 
				case "": //시작시
				case "사각":
				case "직선":
				case "타원":
					ShapeMove(select,selectIndex,end,btwX,btwY); //도형 이
					break;
				}
			}
			repaint();
		}
	}
	////* 도형 그리는 메소드 *////
	public void paintComponent(Graphics g) { //도형 그리기
      super.paintComponent(g); 
      
      for(int i=0;i<shapes.size();i++) { //배열 내에 저장된 도형 전체 출력
      	Shape shape=shapes.get(i);
      	if(shape.equal(select)&&selectBtn!=""&&selectBtn!="복사"&&selectBtn!="삭제") {
      		continue; //이동, 크기조절할때 선택된 도형을 그리지않게함
      	}
      	shape.draw(g);
      }
      cp.draw(g);
      
      if(start==null||end==null) //프로그램 시작시 실행되는 오류 방지
    	  return;
      
      if(isFocusCP) {  //도형 크기 조절
    	 	switch(selectBtn) {
    	 		case "사각":
    	 		case "직선":
    	 		case "타원":
    	 			if(cp.isCp1()) {
    	 				SizeChangeDrawCp1(g);
        	          	break;
    	 			}else { //cp.isCp2()==True
    	 				SizeChangeDrawCp2(g);
        	          	break;
    	 			}
    	 	}
			return;
      }else if(isFocusS==false) { //드래그로 도형생성   
    	  calculateMakeV(start,end);
          switch(selectBtn) {
          	case "사각":
	        	g.drawRect(x, y, width, height);
	        	break;
	        case "직선":
	        	g.drawLine(start.x,start.y,end.x,end.y);
	        	break;
	        case "타원":
	        	g.drawOval(x, y, width, height);
	        	break;
	        }
	      	return;
      }else {//도형 이동
    	  switch(selectBtn) { //도형이 이동되는 동안 그리는 것
	        case "사각":
	        case "직선":
	        case "타원":
	          	ShapeMoveDraw(g);
	          	break;
	          }
      }
  }
	////////////////////////이벤트 관련 함수 모음//////////////////////////////////////////
	public void calculateMakeV(Point start,Point end) {
		x=Math.min(start.x, end.x);
        y=Math.min(start.y, end.y);
        x2=Math.max(start.x, end.x);
        y2=Math.max(start.y, end.y);
        width=Math.abs(start.x-end.x);
        height=Math.abs(start.y-end.y);
	}
	public boolean isShapeOrCpSelect(ArrayList<Shape> shapes,ControlPoint cp) {
		for(int i=shapes.size()-1;i>=0;i--) { //선택:뒤에서부터 확인해서 도형겹침이나 순서 고려
			Shape tmp=shapes.get(i);
			if(tmp.include(start)) {
				select=tmp;
				selectIndex=i;
				cp.cpChange(select);
				cp.setShow(true);
				if(cp.include(start)) {
					isFocusCP=true;
					 //클릭되면 크기조절 이벤트로
					return true;
				}
				isFocusCP=false;
				isFocusS=true;
				return true; //중복될 일 없으니까
			}else {
				select=null;
				cp.setShow(false);
				isFocusS=false;
			}
		}
		return false;
	}
	public void ShapeCopy(Shape select,int selectIndex,ArrayList<Shape> shapes) {//도형 복사
		Shape copy = null;
		if(select==null) { //선택된 도형이 없다면 이벤트 하지 않음
			return;
		}
		if(select instanceof Rectangle) { //shape를 받는 생성자??? selct를 파라미터
			Rectangle s=(Rectangle)select;
			copy=new Rectangle(s.x+10,s.y+10,s.getWidth(),s.getHeight());//s.x+10,s.y+10,s.width,s.height
		}
		if(select instanceof Line) {
			Line s=(Line)select;
			copy=new Line(s.x+10,s.y,s.getX2()+10,s.getY2());
		}
		if(select instanceof Oval) {
			Oval s=(Oval)select;	
			copy=new Oval(s.x+10,s.y+10,s.getWidth(),s.getHeight());//s.x+10,s.y+10,s.width,s.height
		}
		shapes.add(copy);
	}
	public void ShapeMove(Shape select,int selectIndex,Point end,int btwX,int btwY) {//도형 이동
		int px=end.x-btwX;
		int py=end.y-btwY;
		if(select instanceof Rectangle) {
			Rectangle tmp=(Rectangle)select;
			Rectangle s=new Rectangle(px,py,tmp.getWidth(),tmp.getHeight());//(Rectangle)select;
			shapes.set(selectIndex, s);
		}else if(select instanceof Line) {
			Line tmp=(Line)select;//s.x+10,s.y+10,s.width,s.height
			int lenX=tmp.getX2()-tmp.x;
      		int lenY=tmp.getY2()-tmp.y;
			Line s=new Line(px,py,px+lenX,py+lenY);
			shapes.set(selectIndex, s);
		}else if(select instanceof Oval){
			Oval tmp=(Oval)select;
			Oval s=new Oval(px,py,tmp.getWidth(),tmp.getHeight());
			shapes.set(selectIndex, s);
		}
		return;
	}
	public void ShapeMoveDraw(Graphics g) {//도형 이동 그리기
		int px=end.x-btwX;
      	int py=end.y-btwY;
      	if(select instanceof Rectangle) {
      		Rectangle s=(Rectangle)select;
      		g.drawRect(px,py, s.getWidth(),s.getHeight());//start.x-btwX, start.y-btwY
      		cp.cpChange(px,py,px+s.getWidth(),py+s.getHeight());
      		
      	}else if(select instanceof Line) {
      		Line s=(Line)select;
      		int lenX=s.getX2()-s.x;
      		int lenY=s.getY2()-s.y;
      		g.drawLine(px,py,px+lenX,py+lenY);
      		cp.cpChange(px,py,px+lenX,py+lenY);
      	}else{
      		Oval s=(Oval)select;
      		g.drawOval(px,py,s.getWidth(),s.getHeight());
      		cp.cpChange(px,py, px+s.getWidth(),py+s.getHeight());
      	}	
      	cp.draw(g);
	}
	public void SizeChangeWCp1(Shape select,int selectIndex,ArrayList<Shape> shapes) {//cp1 클릭시 도형 크기조절
		int width=start.x-end.x;
		int height=start.y-end.y;
		if(select instanceof Rectangle) {
			Rectangle tmp=(Rectangle)select;
			Shape s=new Rectangle(end.x,end.y,width+tmp.getWidth(),height+tmp.getHeight());
			shapes.set(selectIndex,s);
		}else if(select instanceof Line) {
			Line tmp=(Line)select;
			Shape s=new Line(end.x,end.y,tmp.getX2(),tmp.getY2());//s.x+10,s.y+10,s.width,s.height
			shapes.set(selectIndex,s);
		}else{
			Oval tmp=(Oval)select;
			Shape s=new Oval(end.x,end.y,width+tmp.getWidth(),height+tmp.getHeight());
			shapes.set(selectIndex,s);
		}
		cp.setCp1(false);
		isFocusCP=false;
	}
	public void SizeChangeWCp2(Shape select,int selectIndex,ArrayList<Shape> shapes) {//cp2 클릭시 도형 크기조절
		if(select instanceof Rectangle) {
			Shape s=new Rectangle(select.x,select.y,end.x-select.x,end.y-select.y);
			shapes.set(selectIndex,s);
		}else if(select instanceof Line) {
			Line s=new Line(select.x,select.y,end.x,end.y);
			shapes.set(selectIndex,s);
		}else{
			Oval s=new Oval(select.x,select.y,end.x-select.x,end.y-select.y);
			shapes.set(selectIndex,s);
		}
		cp.setCp2(false);
		isFocusCP=false;
	}
	public void SizeChangeDrawCp1(Graphics g) { //cp1 클릭시 도형 크기조절 그리기
		int width=start.x-end.x;
		int height=start.y-end.y;
		int x2=start.x;
		int y2=start.y;
		if(select instanceof Rectangle) {
      		Rectangle s=(Rectangle)select;
      		g.drawRect(end.x,end.y,width+s.getWidth(),height+s.getHeight());//start.x-btwX, start.y-btwY
      		cp.cpChange(end.x,end.y,x2+s.getWidth(),y2+s.getHeight());//width+s.width,height+s.height
      	}else if(select instanceof Line) {
      		Line s=(Line)select;
      		g.drawLine(end.x,end.y,s.getX2(),s.getY2());
    	 	cp.cpChange(end.x,end.y,s.getX2(),s.getY2());
      	}else{
      		Oval s=(Oval)select;
      		g.drawOval(end.x,end.y,s.x-end.x+s.getWidth(),s.y-end.y+s.getHeight());
      		cp.cpChange(end.x,end.y,x2+s.getWidth(),y2+s.getHeight());
      	}	
		cp.draw(g);	
	}
	public void SizeChangeDrawCp2(Graphics g) { //cp2 클릭시 도형 크기조절 그리기
		if(select instanceof Rectangle) {
      		Rectangle s=(Rectangle)select;
      		g.drawRect(s.x,s.y,end.x-s.x,end.y-s.y);
      		cp.cpChange(s.x,s.y,end.x,end.y);
      		
      	}else if(select instanceof Line) {
      		Line s=(Line)select;
      		g.drawLine(s.x,s.y,end.x,end.y);
    	 	cp.cpChange(s.x,s.y,end.x,end.y);
      	}else{
      		Oval s=(Oval)select;
      		g.drawOval(s.x,s.y,end.x-s.x,end.y-s.y);
      		cp.cpChange(s.x,s.y,end.x,end.y);
      	}
		cp.draw(g);
	}
}

