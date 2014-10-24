import java.util.ArrayList;


public class Region {
	
	private String name;
	
	ArrayList<Country> countries = new ArrayList<Country>();
	
	public Region(String n) {
		name = n;
		
	}

	public String getName() {
		return name;
	}

	public ArrayList<Country> getCountries() {
		return countries;
	}
	
	public void addCountry(Country c) {
		countries.add(c);
	}
	
	public void printCountries() {
		for(Country c : countries) {
			System.out.println(c.getName());
		}
		
	}
	
	
	

}
