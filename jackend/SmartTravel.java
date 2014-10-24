
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.Scanner;


public class SmartTravel {

	public static ArrayList<Region> regions = new ArrayList<Region>();

	public static void main(String[] args) {
		//String location = args[0];

		init();
		//regions.get(0).printCountries();
	}

	public static void init() {
		readCountries("Africa.txt");
		readCountries("Americas.txt");
		readCountries("Asia.txt");
		readCountries("Europe.txt");
		readCountries("Oceania.txt");

		readPPP("PPP-countries.txt", "PPP-value.txt");
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
				Country country = new Country(splitLine[1], splitLine[0], region);
				reg.addCountry(country);
				//System.out.println(line);
			}
			scanner.close();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
	}

	public void printRegions() {
		for(Region reg : regions) {
			System.out.println(reg.getName());
		}

	}

	public static void readPPP(String countries, String values) {
		File fileC = new File(countries);
		File fileV = new File(values); 

		try {
			Scanner scannerC = new Scanner(fileC);
			Scanner scannerV = new Scanner(fileV);

			while (scannerC.hasNextLine()) {
				String countryLine = scannerC.nextLine();
				String valueLine = scannerV.nextLine();

				Country tmpC = findCountry(countryLine);
				if(tmpC != null) tmpC.setBuyingPower(Double.parseDouble(valueLine));
				

				System.out.println(countryLine + " " + valueLine);
			}
			scannerC.close();
			scannerV.close();
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
	}
	
	public static Country findCountry(String name) {
		for(Region r : regions) {
			for(Country c : r.countries) {
				if(c.equals(name)) return c;
			}
		}
		return null;
		
	}

	public static void connect() {
		
	}

}
