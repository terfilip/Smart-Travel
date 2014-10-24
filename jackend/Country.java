
public class Country {
	
	private String name;
	private String acro;
	private String region;
	private String currencyName;
	private double buyingPower;
	
	private double currency;	
	
	public Country(String n, String a, String r) {
		name = n;
		acro = a;
		region = r;
	}

	public String getName() {
		return name;
	}
	public String getCurrency() {
		return currencyName;
	}
	public double getBuyingPower() {
		return buyingPower;
	}
	public String getRegion() {
		return region;
	}
	
	

	public void setBuyingPower(double parseDouble) {
		this.buyingPower = buyingPower;
		
	}
	
	
	
	

}
