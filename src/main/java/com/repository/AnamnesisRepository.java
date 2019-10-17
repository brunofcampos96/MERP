package com.repository;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

import com.Entity.AnamnesisEntity;

@Repository
public interface AnamnesisRepository extends CrudRepository<AnamnesisEntity, Long>{

}