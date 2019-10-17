package com.service;

import java.util.ArrayList;
import java.util.List;

import com.entity.IEntity;

public class IService {	
	public List<IEntity> getAll();
	
	public IEntity getById(Long id);

    public void saveOrUpdate(IEntity entity);
    
	public void delete(Long id);
}