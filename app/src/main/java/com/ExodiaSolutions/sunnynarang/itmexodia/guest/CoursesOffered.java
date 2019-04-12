package com.ExodiaSolutions.sunnynarang.itmexodia.guest;

import android.graphics.Typeface;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.TextView;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;

public class CoursesOffered extends AppCompatActivity {
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                CoursesOffered.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_courses_offered);
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Programmes Offered");

        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);
        TextView textView = (TextView) findViewById(R.id.guest_head);
        TextView textView1 = (TextView) findViewById(R.id.guest_head1);
        Typeface type1 = Typeface.createFromAsset(getAssets(),"fonts/Oswald-Regular.ttf");
        textView.setTypeface(type1);
        textView1.setTypeface(type1);
    }
}
