import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

public class Scrap
{
	public static void main(String[] args)
	{
		try
		{
			// URL of the login page
			String url = "http://di-docker:54688/signup.html";
			Document doc = Jsoup.connect(url).get();

			// Print the title of the page
			System.out.println("Title: " + doc.title());

			// Select the form element
			Element form = doc.selectFirst("form.auth-form");
			if (form != null)
			{
				System.out.println("Form found: " + form);

				// Extract the email and password input fields
				Element emailInput = form.selectFirst("input[name=email]");
				Element passwordInput = form.selectFirst("input[name=password]");

				if (emailInput != null)
				{
					System.out.println("Email field found: Name = " + emailInput.attr("name") + ", Type = "
							+ emailInput.attr("type"));
				}
				else
				{
					System.out.println("Email input field not found.");
				}

				if (passwordInput != null)
				{
					System.out.println("Password field found: Name = " + passwordInput.attr("name") + ", Type = "
							+ passwordInput.attr("type"));
				}
				else
				{
					System.out.println("Password input field not found.");
				}
			}
			else
			{
				System.out.println("Login form not found.");
			}
		} catch (Exception e)
		{
			e.printStackTrace();
		}
		System.out.println("Scraping completed.");
		System.exit(0);
	}
}