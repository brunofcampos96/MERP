package com.repository;
import org.springframework.data.repository.CrudRepository;
import org.springframework.stereotype.Repository;

import com.Entity.PrescriptionEntity;

@Repository
public interface PrescriptionRepository extends CrudRepository<PrescriptionEntity, Long>{

}