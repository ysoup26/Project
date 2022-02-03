package test;
import java.util.Scanner;
//5735번: Emoticons
public class Main {
	public static void main(String []args) {
		Scanner scan=new Scanner(System.in);
		while(true) {
			int emoteCount=0;
			int N=scan.nextInt();
			int M=scan.nextInt();
			if(N==0||M==0)
				return;
			String []emote=new String[N];
			String []text=new String[M];
			for(int i=0;i<N;i++) {
				emote[i]=scan.next();
			}
			scan.nextLine();//남아있는 공백문자 버퍼에서 지움(\n)
			for(int i=0;i<M;i++) {
				text[i]=scan.nextLine();
			}
			
			for(int i=0;i<M;i++) {
				int indexN=0; //다음줄로 가면 다시 앞부터
				int findCount=0; //재검사에 대한 변수
				
				while(true) { //한 줄에 대한 이모티콘을 찾는 반복문
					int j=0;
					for(;j<N;j++) {
						int tmpIndex=999;
						if(text[i].indexOf(emote[0],indexN)!=-1) {
							tmpIndex=text[i].indexOf(emote[0],indexN);
						}
						for(int k=1;k<N;k++) { //최소 index 찾기
							if((text[i].indexOf(emote[k],indexN)!=-1)&&(tmpIndex>text[i].indexOf(emote[k],indexN)))
								tmpIndex=text[i].indexOf(emote[k],indexN);
						}
						if(tmpIndex!=999) {
							emoteCount++;
							indexN=tmpIndex+emote[j].length(); //이모티콘 길이만큼 뒤로
							findCount=0;
							break;
						}
					}
					if(indexN!=999&&findCount==0) { //재검사
						findCount++;
						continue;
					}else if(findCount==1){ //재검사했는데 이모티콘을 못찾음-다음줄로
						break;
					}else//해당 줄에 이모티콘이 없음-다음줄로
						break;		
				}
			}
			System.out.println("");
			System.out.print(emoteCount);
		}
	}
}