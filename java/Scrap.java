import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;

public class Scrap
{
	public static void main(String[] args) 
	{
		try {
			String url = "http://di-docker:54688/";
			Document doc = Jsoup.connect(url).get();
			System.out.println("Title: " + doc.title());
		} catch (Exception e) {
			e.printStackTrace();
		}
		System.out.println("Scraping completed.");
		System.exit(0);
	}
}