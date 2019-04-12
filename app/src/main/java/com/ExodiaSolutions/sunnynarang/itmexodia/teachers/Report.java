package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.GridLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.EndlessRecyclerViewScrollListener;
import com.ExodiaSolutions.sunnynarang.itmexodia.Link;
import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.ExodiaSolutions.sunnynarang.itmexodia.RecyclerItemClickListener;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;

public class Report extends AppCompatActivity {
    RecyclerView recyclerView;
    RecyclerCustomAdapter adapter;
private String roll_teacher;
    ProgressDialog pd;
    String login_url= null;
    private int num_of_reports=0;
    private ArrayList<Att_list_class> arrayList = new ArrayList<>();
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                Report.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_report);
        roll_teacher = getIntent().getStringExtra("roll");
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("Attendance Report");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);

        recyclerView = (RecyclerView) findViewById(R.id.report_recycler);
        adapter=new Report.RecyclerCustomAdapter(Report.this,arrayList);

        recyclerView.setAdapter(adapter);
        //LinearLayoutManager layoutManager = new LinearLayoutManager(Report.this,LinearLayoutManager.VERTICAL,false);
        GridLayoutManager layoutManager = new GridLayoutManager(this,1);
        recyclerView.setLayoutManager(layoutManager);
        adapter.notifyDataSetChanged();

        recyclerView.addOnItemTouchListener( new RecyclerItemClickListener(Report.this, new RecyclerItemClickListener.OnItemClickListener() {
            @Override public void onItemClick(View view, int position) {
                // TODO Handle item click
                Att_list_class a  = arrayList.get(position);
                Intent i = new Intent(Report.this, ViewReport.class);
                i.putExtra("subject_id",a.getSuject_id());
                i.putExtra("date",a.getDate());
                i.putExtra("time",a.getTime());
                i.putExtra("roll",roll_teacher);
                i.putExtra("section_id",a.getsection_id());
                i.putExtra("absent_st_list",a.getAbsent_st_list());
                startActivity(i);
                //Toast.makeText(Report.this, ""+a.getDate()+a.getClass_id()+a.getSuject_id(), Toast.LENGTH_SHORT).show();


            }
        }));

        recyclerView.addOnScrollListener(new EndlessRecyclerViewScrollListener(layoutManager) {
            @Override
            public void onLoadMore(int page, int totalItemsCount) {
                // Triggered only when new data needs to be appended to the list
                // Add whatever code is needed to append new items to the bottom of the list
               if(isNetworkAvailable()){
                num_of_reports+=20;
                final ReportLoader reportLoader = new ReportLoader(Report.this);
                reportLoader.execute();

                   Handler handler = new Handler();
                   handler.postDelayed(new Runnable()
                   {
                       @Override
                       public void run() {
                           if ( reportLoader.getStatus() == AsyncTask.Status.RUNNING )
                           {reportLoader.cancel(true);
                               Toast.makeText(Report.this, "Time OUT", Toast.LENGTH_SHORT).show();
                               if(pd.isIndeterminate())
                               pd.dismiss();
                           }
                       }
                   }, 20000 );
               }
                else{
                Toast.makeText(Report.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
            }

        }
        });
        if(isNetworkAvailable()){
        ReportLoader reportLoader = new ReportLoader(Report.this);
        reportLoader.execute();
        }else{
            Toast.makeText(Report.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
        }

    }
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }


    public static class RecyclerCustomAdapter extends
            RecyclerView.Adapter<Report.RecyclerCustomAdapter.ViewHolder> {

        Context mContext;
        ArrayList<Att_list_class> mArrayList;

        //constructor
        public RecyclerCustomAdapter(Context context, ArrayList<Att_list_class> marrayList) {
            mContext = context;
            mArrayList = marrayList;
        }

        //easy access to context items objects in recyclerView
        private Context getContext() {
            return mContext;
        }

        @Override
        public Report.RecyclerCustomAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
            Context context = parent.getContext();
            LayoutInflater inflater = LayoutInflater.from(context);

            // Inflate the custom layout
            View contactView = inflater.inflate(R.layout.report_card, parent, false);

            // Return a new holder instance
            Report.RecyclerCustomAdapter.ViewHolder viewHolder = new Report.RecyclerCustomAdapter.ViewHolder(contactView);
            return viewHolder;

        }

        @Override
        public void onBindViewHolder(Report.RecyclerCustomAdapter.ViewHolder viewHolder, int position) {

            // Get the data model based on position
            Att_list_class a = mArrayList.get(position);

            // Set item views based on your views and data model

            TextView branch_tv=viewHolder.branch_tv;
            TextView sem_tv=viewHolder.sem_tv;
            TextView date_tv=viewHolder.date_tv;
            TextView classes_tv=viewHolder.classes_tv;
            TextView subject_tv=viewHolder.subject_tv;
           // TextView total_tv=viewHolder.total_tv;
           // TextView present_tv=viewHolder.present_tv;
           // TextView absent_tv=viewHolder.absent_tv;
            branch_tv.setText(a.getBranch());
            sem_tv.setText("SEM - "+a.getSem());
            date_tv.setText(a.getDate());
            classes_tv.setText(a.getClasses());
            subject_tv.setText("[] "+a.getsubject().toUpperCase()+" ("+a.getTime()+")");
            //total_tv.setText("60");
           // present_tv.setText("50");
           // absent_tv.setText("10");
             //stripe1.setText(a.getClasses()+" | Sem - "+a.getSem()+" | "+a.getsubject()+" | "+a.getDate());
            //stripe2.setText(a.getCourse()+" | "+a.getBranch());
           
        }

        @Override
        public int getItemCount() {
            return mArrayList.size();
        }

        public static class ViewHolder extends RecyclerView.ViewHolder {
           // public TextView stripe1, stripe2;
            public TextView branch_tv,sem_tv,date_tv,classes_tv,subject_tv,total_tv,present_tv,absent_tv;

            public ViewHolder(View itemView) {
                super(itemView);
                
                branch_tv = (TextView) itemView.findViewById(R.id.report_branch);
                sem_tv = (TextView) itemView.findViewById(R.id.report_sem);
                date_tv = (TextView) itemView.findViewById(R.id.report_date);
                classes_tv = (TextView) itemView.findViewById(R.id.report_class);
                subject_tv = (TextView) itemView.findViewById(R.id.report_subject_id);
               // total_tv = (TextView) itemView.findViewById(R.id.report_total);
               // present_tv = (TextView) itemView.findViewById(R.id.report_present);
              //  absent_tv = (TextView) itemView.findViewById(R.id.report_absent);


            }
        }

    }

    public class ReportLoader extends AsyncTask<Void,Void,String> {

        Context context;

        ReportLoader(Context context)
        {
            this.context=context;
        }
        @Override
        protected String doInBackground(Void... params) {


            if( Link.getInstance().getHashMapLink().containsKey("view_att_report")){
                login_url = Link.getInstance().getHashMapLink().get("view_att_report");
            }

            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("roll", "UTF-8") + "=" + URLEncoder.encode(roll_teacher, "UTF-8") + "&"
                        + URLEncoder.encode("num", "UTF-8") + "=" + URLEncoder.encode(""+num_of_reports, "UTF-8");

                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }

            return "";
        }


        @Override
        protected void onPreExecute() {
            super.onPreExecute();
if(num_of_reports==0){
                pd = new ProgressDialog(Report.this);
                pd.setTitle("Loading.");
                pd.setMessage("Please wait...\nLoading Report.");
                pd.setCancelable(false);
                pd.show();}
        }

        @Override
        protected void onPostExecute(String result ){
            //Toast.makeText(Report.this, ""login_url+result, Toast.LENGTH_SHORT).show();
                if(num_of_reports==0)pd.dismiss();
            if(!result.equalsIgnoreCase("")){
               //Toast.makeText(Report.this, ""+result, Toast.LENGTH_SHORT).show();
            arrayList.addAll(Att_list_class.jsonToArraylist(result,context));
               // Toast.makeText(context, ""+arrayList.size(), Toast.LENGTH_SHORT).show();
            adapter.notifyDataSetChanged();
            }


    }
}}