package com.service;

import java.util.ArrayList;
import java.util.List;

import com.entity.IEntity;
import org.springframework.data.repository.CrudRepository;

public class AbstractService implements IService {
	CrudRepository repository;
	
	public List<IEntity> getAll() {
        List<IEntity> entities = new ArrayList<IEntity>();
        repository.findAll().forEach(entity -> entities.add(entity));
        return entities;
	}
	
	public IEntity getById(Long id) {
        return repository.findById(id).get();
    }

	public void saveOrUpdate(IEntity entity) {
        repository.save(entity);
    }
	public void delete(Long id) {
        repository.deleteById(id);
    }
}
