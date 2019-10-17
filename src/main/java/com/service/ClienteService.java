package com.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.List;

import com.entity.IEntity;
import com.repository.ClienteRepository;

@Service
public class ClienteService extends AbstractService {

    @Autowired
    public void setRepository(ClienteRepository repository){
        this.repository = repository;
    }
	
	public List<IEntity> getAll() {
        return super.getAll();
	}
	
	public IEntity getById(Long id) {
        return super.getById(id);
    }

	public void saveOrUpdate(IEntity entity) {
        super.saveOrUpdate(entity);
    }
	public void delete(Long id) {
        super.delete(id);
    }
}
