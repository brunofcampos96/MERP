package com.repository;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

import com.Entity.AgendaEntity;

@Repository
public interface AgendaRepository extends CrudRepository<AgendaEntity, Long>{

}