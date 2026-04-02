package com.example.reviewservice.model;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.validation.constraints.Max;
import javax.validation.constraints.Min;
import javax.validation.constraints.NotEmpty;
import javax.validation.constraints.NotNull;

@Entity
public class Review {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @NotNull(message = "Product ID is required")
    private Long productId;

    @NotEmpty(message = "Reviewer name cannot be empty")
    private String reviewerName;

    @NotEmpty(message = "Comment cannot be empty")
    private String comment;

    @Min(1)
    @Max(5)
    private int rating;

    public Review() {}
    public Review(Long productId, String reviewerName, String comment, int rating) {
        this.productId = productId;
        this.reviewerName = reviewerName;
        this.comment = comment;
        this.rating = rating;
    }
    public Long getId() { return id; }
    public void setId(Long id) { this.id = id; }
    public Long getProductId() { return productId; }
    public void setProductId(Long productId) { this.productId = productId; }
    public String getReviewerName() { return reviewerName; }
    public void setReviewerName(String reviewerName) { this.reviewerName = reviewerName; }
    public String getComment() { return comment; }
    public void setComment(String comment) { this.comment = comment; }
    public int getRating() { return rating; }
    public void setRating(int rating) { this.rating = rating; }
}
