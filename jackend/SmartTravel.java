
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Scanner;


public class SmartTravel {
	
	public static ArrayList<Region> regions = new ArrayList<Region>();

	public static void main(String[] args) {
		init();
	}
	
	
	public static void init() {
		readCountries("Africa.txt");
		readCountries("Americas.txt");
		readCountries("Asia.txt");
		readCountries("Europe.txt");
		readCountries("Oceania.txt");
		
		
	}
	
	public static void readCountries(String region) {
		File file = new File(region); 
		Region reg = new Region(region);
		regions.add(reg);
        try {
 
            Scanner scanner = new Scanner(file);
 
            while (scanner.hasNextLine()) {
                String line = scanner.nextLine();
                String[] splitLine = line.split(":");
                Country country = new Country(splitLine[1], splitLine[0]);
                reg.addCountry(country);
                //System.out.println(line);
            }
            scanner.close();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        }
	}
	
	public void connect() {
		
		try{
		String urlParameters = "";
		String request = "https://devapi.thecurrencycloud.com/v2/authenticate/api";
		URL url = new URL(request); 
		HttpURLConnection connection = (HttpURLConnection) url.openConnection();           
		connection.setDoOutput(true);
		connection.setDoInput(true);
		connection.setInstanceFollowRedirects(false); 
		connection.setRequestMethod("POST"); 
		connection.setRequestProperty("Content-Type", "application/x-www-form-urlencoded"); 
		connection.setRequestProperty("charset", "utf-8");
		connection.setRequestProperty("Content-Length", "" + Integer.toString(urlParameters.getBytes().length));
		connection.setUseCaches (false);

		DataOutputStream wr = new DataOutputStream(connection.getOutputStream ());
		wr.writeBytes(urlParameters);
		wr.flush();
		wr.close();
		connection.disconnect();
		} catch(Exception e) {
			System.out.println("Test exception");
		}
		
	}

}
