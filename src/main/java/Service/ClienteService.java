package Service;

public class ClienteService {
	
	private final long id;
	private final String nome;
	private final String cpf;
	private final String email;
	
	public ClienteService(long id, String nome, String cpf, String email){
		this.id = id;
		this.nome = nome;
		this.cpf = cpf;
		this.email = email;
	}

	public long getId(){
		return id;
	}

	public String getNome(){
		return nome;
	}

	public String getCpf(){
		return cpf;
	}

	public String getEmail(){
		return email;
	}


}
