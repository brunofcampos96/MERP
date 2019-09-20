package com.Service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.List;

import com.Entity.ClienteEntity;
import com.Repository.ClienteRepository;


@Service
public class ClienteService {

	@Autowired
	ClienteRepository clienteRepository;
	
	public List<ClienteEntity> getAllClientes() {
        List<ClienteEntity> clientes = new ArrayList<ClienteEntity>();
        clienteRepository.findAll().forEach(cliente -> clientes.add(cliente));
        return clientes;
	}
	
	public ClienteEntity getClienteById(Long id) {
        return clienteRepository.findById(id).get();
    }

	public void saveOrUpdate(ClienteEntity cliente) {
        clienteRepository.save(cliente);
    }
	public void delete(Long id) {
        clienteRepository.deleteById(id);
    }


}
